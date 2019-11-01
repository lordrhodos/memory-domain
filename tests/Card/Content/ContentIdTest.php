<?php declare(strict_types=1);

namespace Memory\Test\Card;

use Memory\Card\Content\ContentId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ContentIdTest extends TestCase
{
    public function test_id_is_valid_uuid(): void
    {
        $id = new ContentId();
        $this->assertInstanceOf(UuidInterface::class, $id->id());
        $this->assertTrue(Uuid::isValid($id->__toString()));
    }

    public function test_create_from_string(): void
    {
        $uuid = Uuid::uuid4()->__toString();
        $id = ContentId::fromString($uuid);

        $this->assertSame($uuid, $id->__toString());
    }

    public function test_create_from_invalud_string_throws_exception(): void
    {
        $this->expectException(InvalidUuidStringException::class);
        ContentId::fromString('foo');
    }
}
