<?php declare(strict_types=1);

namespace Memory\Card;

use Memory\Contracts\ContentTypes;

class ColourCard extends Card
{
    public function getContentType(): string
    {
        return ContentTypes::COLOUR;
    }
}
