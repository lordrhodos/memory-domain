<?php declare(strict_types=1);

namespace Memory\Test\Card;

use Memory\Card\CardId;
use Memory\Card\ColourCard;
use Memory\Card\DecoratedCard;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DecoratedCardTest extends TestCase
{
    private const TITLE = 'foo';
    private const CONTENT = 'red';

    public function test_get_card_id_returns_original_card_id(): void
    {
        $cardId = new CardId();
        $card = new ColourCard(self::TITLE, self::CONTENT);
        $decorated = new DecoratedCard($cardId, $card);
        $this->assertSame($card->id(), $decorated->cardId());
    }

    public function test_get_id_returns_valid_uuid(): void
    {
        $cardId = new CardId();
        $card = new ColourCard(self::TITLE, self::CONTENT);
        $decorated = new DecoratedCard($cardId, $card);

        $this->assertTrue(Uuid::isValid($decorated->id()));
    }

    public function test_proxy_methods(): void
    {
        $cardId = new CardId();
        $card = new ColourCard(self::TITLE, self::CONTENT);
        $decorated = new DecoratedCard($cardId, $card);

        $this->assertSame(self::TITLE, $decorated->title());
        $this->assertSame(self::CONTENT, $decorated->content());
        $this->assertSame(ContentTypes::COLOUR, $decorated->contentType());
    }
}
