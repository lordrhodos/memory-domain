<?php declare(strict_types=1);

namespace Memory\Test;

use Memory\Card\CardId;
use Memory\Card\Card;
use Memory\Card\Content\ContentId;
use Memory\Card\Content\ImageContent;
use Memory\Pair;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PairTest extends TestCase
{
    public const FIRST_CARD_ID = '692aa93a-e1b4-451d-8c28-4c57fe1acc25';
    public const SECOND_CARD_ID = '02c9e402-964c-488d-acce-e12c9e1cd819';

    public function test_is_instantiable(): void
    {
        $pair = $this->createPair();
        $this->assertInstanceOf(Pair::class, $pair);
    }

    public function test_cards_can_be_retrieved(): void
    {
        $pair = $this->createPair();
        [$firstCard, $secondCard] = $pair->getCards();

        $this->assertInstanceOf(Card::class, $firstCard);
        $this->assertSame(self::FIRST_CARD_ID, $firstCard->id()->__toString());
        $this->assertTrue(Uuid::isValid($firstCard->id()));

        $this->assertInstanceOf(Card::class, $secondCard);
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
        $this->assertNotSame($firstCard->contentId(), $secondCard->contentId());

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
        $this->assertSame($firstCard->contentId()->__toString(), $secondCard->contentId()->__toString());

        $matches = $pair->matchesIds($firstId, $secondId);
        $this->assertTrue($matches);

    }

    private function createPair(string $firstId = self::FIRST_CARD_ID, string $secondId = self::SECOND_CARD_ID): Pair
    {
        $cardId = CardId::fromString($firstId);
        $contentMock = $this->createContentMock($firstId);

        $secondCardId = CardId::fromString($secondId);
        $secondContentMock = $this->createContentMock($secondId);

        $firstCard = new Card($cardId, $contentMock);
        $secondCard = new Card($secondCardId, $secondContentMock);

        return new Pair($firstCard, $secondCard);
    }

    private function createContentMock(string $id): ImageContent
    {
        $contentMock = $this->createMock(ImageContent::class);
        $ccontentId = ContentId::fromString($id);
        $contentMock->method('id')->willReturn($ccontentId);

        return $contentMock;
    }
}
