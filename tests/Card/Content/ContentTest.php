<?php declare(strict_types=1);

namespace Memory\Test\Card\Content;

use Memory\Card\Content\Content;
use Memory\Card\Content\ContentId;
use Memory\Card\Content\ImageContent;
use Memory\Contracts\Content as CardContract;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ContentTest extends TestCase
{
    const TITLE = 'Card Title';
    const CONTENT = 'https://placehold.it/120x120&text=image1';

    public function test_is_instantiable(): void
    {
        $content = $this->createContent();
        $this->assertInstanceOf(ImageContent::class, $content);
    }

    public function test_each_content_returns_a_uuid_as_id(): void
    {
        $contentIds = [];
        for ($i = 0; $i < 1000; $i++) {
            $content = $this->createContent();
            $uuid = $content->id();
            $this->assertTrue(Uuid::isValid($uuid));
            $contentIds[] = $uuid;
        }

        $unique = array_unique($contentIds);
        $this->assertSame($contentIds, $unique);
    }

    public function test_content_requires_name_and_image_url_on_creation()
    {
        $content = $this->createContent();

        $this->assertSame(self::TITLE, $content->title());
        $this->assertSame(self::CONTENT, $content->content());
    }

    private function createContent(): ImageContent
    {
        $contentId = new ContentId();
        $content = new ImageContent($contentId, self::TITLE, self::CONTENT);

        return $content;
    }
}
