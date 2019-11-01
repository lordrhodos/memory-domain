<?php declare(strict_types=1);

namespace Memory\Test\Card\Content;

use Memory\Card\Content\AudioContent;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class ColourContentTest extends TestCase
{
    private const CONTENT = 'green';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $card = new AudioContent(self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::AUDIO, $card->contentType());
    }
}
