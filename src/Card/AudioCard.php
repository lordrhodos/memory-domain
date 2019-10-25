<?php declare(strict_types=1);

namespace Memory\Card;

use Memory\Card\Card;
use Memory\Contracts\ContentTypes;
use Ramsey\Uuid\Uuid;

class ColourCard extends Card
{
    /**
     * @var string
     */
    private $colour;

    public function __construct(string $title, string $colour)
    {
        parent::__construct($title);
        $this->colour = $colour;
    }

    public function getContent(): string
    {
        return $this->colour;
    }

    public function getContentType(): string
    {
        return ContentTypes::COLOUR;
    }
}
