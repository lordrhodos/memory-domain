<?php declare(strict_types=1);

namespace Memory\Test;

use Memory\Card\CardId;
use Memory\Card\DecoratedCard;
use Memory\Card\ImageCard;
use Memory\Pair;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PairTest extends TestCase
{
    private const FIRST_CARD_ID = '692aa93a-e1b4-451d-8c28-4c57fe1acc25';
    private const SECOND_CARD_ID = '02c9e402-964c-488d-acce-e12c9e1cd819';

    public function test_is_instantiable(): void
    {
        $pair = $this->createPair();
        $this->assertInstanceOf(Pair::class, $pair);
    }

    public function test_cards_can_be_retrieved(): void
    {
        $pair = $this->createPair();
        [$firstCard, $secondCard] = $pair->getCards();

        $this->assertInstanceOf(DecoratedCard::class, $firstCard);
        $this->assertSame(self::FIRST_CARD_ID, $firstCard->id()->__toString());
        $this->assertTrue(Uuid::isValid($firstCard->id()));

        $this->assertInstanceOf(DecoratedCard::class, $secondCard);
        $this->assertSame(self::SECOND_CARD_ID, $secondCard->id()->__toString());
        $this->assertTrue(Uuid::isValid($secondCard->id()));
    }

    public function test_matches_different_card_ids(): void
    {
        $pair = $this->createPair();
        [$firstCard, $secondCard] = $pair->getCards();
        $firstId = $firstCard->id();
        $secondId = $secondCard->id();

        $this->assertNotSame($firstId, $secondId);
        $this->assertNotSame($firstCard->cardId(), $secondCard->cardId());

        $matches = $pair->matchesIds($firstId, $secondId);
        $this->assertTrue($matches);
    }

    public function test_matches_same_card_ids(): void
    {
        $pair = $this->createPair(self::FIRST_CARD_ID, self::FIRST_CARD_ID);
        [$firstCard, $secondCard] = $pair->getCards();

        $firstId = $firstCard->id();
        $secondId = $secondCard->id();
        $this->assertNotSame($firstId, $secondId);
        $this->assertSame($firstCard->cardId()->__toString(), $secondCard->cardId()->__toString());

        $matches = $pair->matchesIds($firstId, $secondId);
        $this->assertTrue($matches);

    }

    private function createPair(string $firstId = self::FIRST_CARD_ID, string $secondId = self::SECOND_CARD_ID): Pair
    {
        $cardId = CardId::fromString($firstId);
        $cardMock = $this->createCardMock($firstId);

        $secondCardId = CardId::fromString($secondId);
        $secondCardMock = $this->createCardMock($secondId);

        return new Pair(new DecoratedCard($cardId, $cardMock), new DecoratedCard($secondCardId, $secondCardMock));
    }

    private function createCardMock(string $id): ImageCard
    {
        $cardMock = $this->createMock(ImageCard::class);
        $cardId = CardId::fromString($id);
        $cardMock->method('id')->willReturn($cardId);

        return $cardMock;
    }
}
