<?php declare(strict_types=1);

namespace Memory;

use Ramsey\Uuid\Uuid;

class Card
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $image;

    public function __construct(string $title, string $image)
    {
        $this->uuid = Uuid::uuid4()->__toString();
        $this->title = $title;
        $this->image = $image;
    }

    public function getId(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
