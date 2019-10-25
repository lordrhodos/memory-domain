<?php declare(strict_types=1);

namespace Memory\Test;

use Memory\Card\DecoratedCard;
use Memory\Card\ImageCard;
use Memory\Pair;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PairTest extends TestCase
{
    private const FIRST_CARD_ID = 'foo';
    private const SECOND_CARD_ID = 'bar';

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
        $this->assertSame(self::FIRST_CARD_ID, $firstCard->getCardId());
        $this->assertTrue(Uuid::isValid($firstCard->getId()));

        $this->assertInstanceOf(DecoratedCard::class, $secondCard);
        $this->assertSame(self::SECOND_CARD_ID, $secondCard->getCardId());
        $this->assertTrue(Uuid::isValid($secondCard->getId()));
    }

    public function test_matches_different_card_ids(): void
    {
        $pair = $this->createPair();
        [$firstCard, $secondCard] = $pair->getCards();
        $firstId = $firstCard->getId();
        $secondId = $secondCard->getId();

        $this->assertNotSame($firstId, $secondId);
        $this->assertNotSame($firstCard->getCardId(), $secondCard->getCardId());

        $matches = $pair->matchesIds($firstId, $secondId);
        $this->assertTrue($matches);
    }

    public function test_matches_same_card_ids(): void
    {
        $pair = $this->createPair(self::FIRST_CARD_ID, self::FIRST_CARD_ID);
        [$firstCard, $secondCard] = $pair->getCards();


        $firstId = $firstCard->getId();
        $secondId = $secondCard->getId();
        $this->assertNotSame($firstId, $secondId);
        $this->assertSame($firstCard->getCardId(), $secondCard->getCardId());

        $matches = $pair->matchesIds($firstId, $secondId);
        $this->assertTrue($matches);

    }

    private function createPair(string $firstId = self::FIRST_CARD_ID, string $secondId = self::SECOND_CARD_ID): Pair
    {
        $cardMock = $this->createCardMock($firstId);
        $secondCardMock = $this->createCardMock($secondId);

        return new Pair(new DecoratedCard($cardMock), new DecoratedCard($secondCardMock));
    }

    private function createCardMock(string $id): ImageCard
    {
        $cardMock = $this->createMock(ImageCard::class);
        $cardMock->method('getId')->willReturn($id);

        return $cardMock;
    }
}
