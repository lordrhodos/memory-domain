<?php declare(strict_types=1);

namespace Memory\Test;

use InvalidArgumentException;
use Memory\Card\CardId;
use Memory\Card\Card;
use Memory\Card\Content\ContentId;
use Memory\Card\Content\ImageContent;
use Memory\Game;
use Memory\Pair;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GameTest extends TestCase
{
    public function test_is_instantiable(): void
    {
        $firstPair = $this->createPair($this->createUuid(), $this->createUuid());
        $secondPair = $this->createPair($this->createUuid(), $this->createUuid());
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
            $pairs[] = $this->createPair($this->createUuid(), $this->createUuid());
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
        $firstCardId = new CardId();
        $firstContent = $this->createContentMock($firstId);
        $secondCardId = new CardId();
        $secondContent = $this->createContentMock($secondId);

        $firstCard = new Card($firstCardId, $firstContent);
        $secondCard = new Card($secondCardId, $secondContent);

        return new Pair($firstCard, $secondCard);
    }

    private function createContentMock(string $id): ImageContent
    {
        $mock = $this->createMock(ImageContent::class);
        $mock->method('id')->willReturn(ContentId::fromString($id));

        return $mock;
    }

    public function test_get_cards_using_unique_cards(): void
    {
        $pairs = $this->createPairs(4);
        $game = new Game(...$pairs);
        $cards = $game->cards();
        $this->assertCount($game->getNumberOfCards(), $cards);
    }

    public function test_duplicate_cards_throw_exception(): void
    {
        $pairs = $this->createPairs(2);
        $duplicated = array_merge($pairs, $pairs);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('duplicate card detected');
        new Game(...$duplicated);
    }

    public function test_make_move_with_invalid_first_card_id_throws_exception(): void
    {
        $firstPair = $this->createPair($this->createUuid(), $this->createUuid());
        $secondPair = $this->createPair($this->createUuid(), $this->createUuid());
        $game = new Game($firstPair, $secondPair);

        $this->expectException(InvalidArgumentException::class);
        $game->makeMove(Uuid::NIL, 'foo');
    }

    public function test_matched_cards_are_empty_on_start(): void
    {
        $pairs = $this->createPairs(4);
        $game = new Game(...$pairs);

        $this->assertCount(8, $game->cards());
        $this->assertEmpty($game->matchedCards());
    }

    public function test_unmatched_cards_equals_cards_on_start(): void
    {
        $pairs = $this->createPairs(4);
        $game = new Game(...$pairs);

        $this->assertCount(8, $game->unmatchedCards());
        $this->assertSame($game->cards(), $game->unmatchedCards());
    }

    public function test_matched_cards_contain_all_cards_after_game_is_finished(): void
    {
        $pairs = $this->createPairs(4);
        $game = new Game(...$pairs);
        foreach ($pairs as $pair) {
            [$firstCard, $secondCard] = $pair->getCards();
            $firstCardId = $firstCard->id()->__toString();
            $secondCardId = $secondCard->id()->__toString();
            $game->makeMove($firstCardId, $secondCardId);
        }

        $this->assertCount(8, $game->matchedCards());
        $this->assertSame($game->cards(), $game->matchedCards());
    }

    /**
     * @return Pair[]
     */
    private function createPairs(int $numberOfPairs): array
    {
        $pairs = [];
        for ($i = 0; $i < $numberOfPairs; $i++) {
            $pairs[] = $this->createPair($this->createUuid(), $this->createUuid());
        }

        return $pairs;
    }
    
    private function createUuid(): string
    {
        return Uuid::uuid4()->__toString();
    }
}
