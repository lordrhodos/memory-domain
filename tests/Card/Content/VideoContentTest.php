<?php declare(strict_types=1);

namespace Memory\Test\Card\Content;

use Memory\Card\Content\ColourContent;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class VideoContentTest extends TestCase
{
    private const CONTENT = 'http//foo.test/image.jpg';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $card = new ColourContent(self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::COLOUR, $card->contentType());
    }
}
