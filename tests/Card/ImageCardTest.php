<?php declare(strict_types=1);

namespace Memory\Test\Card;

use Memory\Card\ImageCard;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class ImageCardTest extends TestCase
{
    private const CONTENT = 'http//foo.test/image.jpg';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $card = new ImageCard(self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::IMAGE, $card->contentType());
    }
}
