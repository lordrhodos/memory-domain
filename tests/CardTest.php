<?php declare(strict_types=1);

namespace Memory\Test;

use Memory\Card\Card;
use Memory\Card\ImageCard;
use Memory\Contracts\Card as CardContract;
use Memory\Contracts\ContentTypes;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CardTest extends TestCase
{
    const TITLE = 'Card Title';
    const IMAGE = 'https://placehold.it/120x120&text=image1';

    public function test_is_instantiable(): void
    {
        $card = new ImageCard(self::TITLE, self::IMAGE);
        $this->assertInstanceOf(ImageCard::class, $card);
    }

    public function test_each_card_returns_a_uuid_as_id(): void
    {
        $cardIds = [];
        for ($i = 0; $i < 1000; $i++) {
            $card = new ImageCard("Card Title {$i}", self::IMAGE);
            $uuid = $card->id();
            $this->assertTrue(Uuid::isValid($uuid));
            $cardIds[] = $uuid;
        }

        $unique = array_unique($cardIds);
        $this->assertSame($cardIds,$unique);
    }

    public function test_card_requires_name_and_image_url_on_creation()
    {
        $title = self::TITLE;
        $image = self::IMAGE;
        $card = new ImageCard($title, $image);

        $this->assertSame($title, $card->title());
        $this->assertSame($image, $card->content());
    }

    private function getCard(string $title): CardContract
    {
        $card = new class($title) extends Card {
            public function contentType(): string
            {
                return ContentTypes::IMAGE;
            }
        };

        return $card;
    }
}
