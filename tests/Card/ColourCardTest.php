<?php declare(strict_types=1);

namespace Memory\Test\Card;

use Memory\Card\AudioCard;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class AudioCardTest extends TestCase
{
    private const CONTENT = 'green';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $card = new AudioCard(self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::AUDIO, $card->contentType());
    }
}
