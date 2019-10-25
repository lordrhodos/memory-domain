<?php declare(strict_types=1);

namespace Memory\Card;

use Memory\Card\Card;
use Memory\Contracts\ContentTypes;
use Ramsey\Uuid\Uuid;

class ImageCard extends Card
{
    /**
     * @var string
     */
    private $image;

    public function __construct(string $title, string $image)
    {
        parent::__construct($title);
        $this->image = $image;
    }

    public function getContent(): string
    {
        return $this->image;
    }

    public function getContentType(): string
    {
        return ContentTypes::IMAGE;
    }
}
