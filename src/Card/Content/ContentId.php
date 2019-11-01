<?php declare(strict_types=1);

namespace Memory\Card\Content;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ContentId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public function __construct(UuidInterface $uuid = null)
    {
        if ($uuid === null) {
            $uuid = Uuid::uuid4();
        }

        $this->uuid = $uuid;
    }

    public function id(): UuidInterface
    {
        return $this->uuid;
    }

    public static function fromString(string $uuid): self
    {
        $uuid = Uuid::fromString($uuid);

        return new self($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid->__toString();
    }
}
