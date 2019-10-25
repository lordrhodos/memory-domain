<?php declare(strict_types=1);

namespace Memory\Test;

use InvalidArgumentException;
use Memory\Card\DecoratedCard;
use Memory\Card\ImageCard;
use Memory\Game;
use Memory\Pair;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function test_is_instantiable(): void
    {
        $firstPair = $this->createPair('foo', 'foo1');
        $secondPair = $this->createPair('bar', 'bar1');
        $game = new Game($firstPair, $secondPair);
        $this->assertInstanceOf(Game::class, $game);
    }

    /**
     * @dataProvider provide_number_of_pairs
     */
    public function test_at_least_two_pairs_required_for_a_game(int $numberOfPairs): void
    {
        $pairs = [];
        for ($index = $numberOfPairs; $index > 0; $index--) {
            $pairs[] = $this->createPair(uniqid(), uniqid());
        }

        if ($numberOfPairs < 2) {
            $this->expectException(InvalidArgumentException::class);
            new Game(...$pairs);
        } else {
            $game = new Game(...$pairs);
            $this->assertSame($numberOfPairs * 2, $game->getNumberOfCards());
        }
    }

    public function provide_number_of_pairs(): array
    {
        return [
            [0],
            [1],
            [2],
            [3],
            [4],
            [5],
            [6],
            [7],
            [8],
            [9],
        ];
    }

    private function createPair(string $firstId, string $secondId): Pair
    {
        $firstCard = $this->createCardMock($firstId);
        $secondCard = $this->createCardMock($secondId);

        return new Pair(new DecoratedCard($firstCard), new DecoratedCard($secondCard));
    }

    private function createCardMock(string $secondId): ImageCard
    {
        $mock = $this->createMock(ImageCard::class);
        $mock->method('getId')->willReturn($secondId);

        return $mock;
    }

    public function test_get_cards_using_unique_cards(): void
    {
        $pairs = $this->createPairs(4);
        $game = new Game(...$pairs);
        $cards = $game->getCards();
        $this->assertCount($game->getNumberOfCards(), $cards);
    }

    public function test_get_cards_using_same_cards(): void
    {
        $pairs = $this->createPairsWithSameCard(4);
        $game = new Game(...$pairs);
        $cards = $game->getCards();
        $this->assertCount($game->getNumberOfCards(), $cards);
    }

    private function createPairs(int $numberOfPairs): array
    {
        $pairs = [];
        for ($i = 0; $i < $numberOfPairs; $i++) {
            $pairs[] = $this->createPair("Card {$i}1", "Card {$i}2");
        }

        return $pairs;
    }
    private function createPairsWithSameCard(int $numberOfPairs): array
    {
        $card = new ImageCard('a card', 'foo');
        $pairs = [];
        for ($i = 0; $i < $numberOfPairs; $i++) {
            $pairs[] = new Pair(new DecoratedCard($card), new DecoratedCard($card));
        }

        return $pairs;
    }
}
