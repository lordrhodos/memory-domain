<?php declare(strict_types=1);

namespace Memory\Test\Card;

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
        $card = new ColourCard(self::TITLE, self::CONTENT);
        $decorated = new DecoratedCard($card);
        $this->assertSame($card->getId(), $decorated->getCardId());
    }

    public function test_get_id_returns_valid_uuid(): void
    {
        $card = new ColourCard(self::TITLE, self::CONTENT);
        $decorated = new DecoratedCard($card);

        $this->assertTrue(Uuid::isValid($decorated->getId()));
    }

    public function test_proxy_methods(): void
    {
        $card = new ColourCard(self::TITLE, self::CONTENT);
        $decorated = new DecoratedCard($card);

        $this->assertSame(self::TITLE, $decorated->getTitle());
        $this->assertSame(self::CONTENT, $decorated->getContent());
        $this->assertSame(ContentTypes::COLOUR, $decorated->getContentType());
    }
}
