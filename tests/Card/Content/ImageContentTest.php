<?php declare(strict_types=1);

namespace Memory\Test\Card\Content;

use Memory\Card\Content\ContentId;
use Memory\Card\Content\ImageContent;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;

class ImageContentTest extends TestCase
{
    private const CONTENT = 'http//foo.test/image.jpg';
    private const TITLE = 'foo';

    public function testContentTypeIsImage(): void
    {
        $contentId = new ContentId();
        $card = new ImageContent($contentId, self::TITLE, self::CONTENT);

        $this->assertSame(self::TITLE, $card->title());
        $this->assertSame(self::CONTENT, $card->content());
        $this->assertSame(ContentTypes::IMAGE, $card->contentType());
    }
}
