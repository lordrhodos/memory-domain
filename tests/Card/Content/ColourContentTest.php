<?php declare(strict_types=1);

namespace Memory\Test\Card\Content;

use Memory\Card\Content\AudioContent;
use Memory\Card\Content\ContentId;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class ColourContentTest extends TestCase
{
    private const CONTENT = 'green';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $contentId = new ContentId();
        $card = new AudioContent($contentId, self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::AUDIO, $card->type());
    }
}
