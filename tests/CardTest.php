<?php declare(strict_types=1);

namespace Memory\Test;

use Memory\Card;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CardTest extends TestCase
{
    const IMAGE = 'https://placehold.it/120x120&text=image1';
    const TITLE = 'Card Title';

    public function test_is_instantiable(): void
    {
        $card = new Card(self::TITLE, self::IMAGE);
        $this->assertInstanceOf(Card::class, $card);
    }

    public function test_each_card_returns_a_uuid_as_id(): void
    {
        $cardIds = [];
        for ($i = 0; $i < 1000; $i++) {
            $card = new Card("Card Title {$i}", self::IMAGE);
            $uuid = $card->getId();
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
        $card = new Card($title, $image);

        $this->assertSame($title, $card->getTitle());
        $this->assertSame($image, $card->getImage());
    }
}
