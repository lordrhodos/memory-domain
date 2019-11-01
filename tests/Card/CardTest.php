<?php declare(strict_types=1);

namespace Memory\Test\Card\Card;

use Memory\Card\CardId;
use Memory\Card\Content\ColourContent;
use Memory\Card\Card;
use Memory\Card\Content\ContentId;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CardTest extends TestCase
{
    private const TITLE = 'foo';
    private const CONTENT = 'red';

    public function test_get_content_id_returns_original_content_id(): void
    {
        $contentId = new ContentId();
        $content = new ColourContent($contentId, self::TITLE, self::CONTENT);

        $cardId = new CardId();
        $card = new Card($cardId, $content);
        $this->assertSame($cardId, $card->id());
        $this->assertSame($contentId, $card->contentId());
    }

    public function test_get_id_returns_valid_uuid(): void
    {
        $contentId = new ContentId();
        $content = new ColourContent($contentId, self::TITLE, self::CONTENT);

        $cardId = new CardId();
        $card = new Card($cardId, $content);

        $this->assertTrue(Uuid::isValid($card->id()));
    }

    public function test_proxy_methods(): void
    {
        $contentId = new ContentId();
        $content = new ColourContent($contentId, self::TITLE, self::CONTENT);

        $cardId = new CardId();
        $card = new Card($cardId, $content);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::COLOUR, $card->contentType());
    }
}
