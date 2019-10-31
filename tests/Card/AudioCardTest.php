<?php declare(strict_types=1);

namespace Memory\Test\Card;

use Memory\Card\VideoCard;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class VideoCardTest extends TestCase
{
    private const CONTENT = 'http//foo.test/audio.mp3';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $card = new VideoCard(self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::VIDEO, $card->contentType());
    }
}
