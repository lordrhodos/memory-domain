<?php declare(strict_types=1);

namespace Memory\Test\Card;

use Memory\Card\ColourCard;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class ColourCardTest extends TestCase
{
    private const CONTENT = 'http//foo.test/image.jpg';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $card = new ColourCard(self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->getTitle());
        $this->assertSame(self::CONTENT, $card->getContent());
        $this->assertSame(ContentTypes::COLOUR, $card->getContentType());
    }
}
