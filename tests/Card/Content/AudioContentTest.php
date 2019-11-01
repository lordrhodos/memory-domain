<?php declare(strict_types=1);

namespace Memory\Test\Card\Content;

use Memory\Card\Content\VideoContent;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class AudioContentTest extends TestCase
{
    private const CONTENT = 'http//foo.test/audio.mp3';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $card = new VideoContent(self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::VIDEO, $card->contentType());
    }
}
