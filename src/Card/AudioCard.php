<?php declare(strict_types=1);

namespace Memory\Card;

use Memory\Contracts\ContentTypes;

class AudioCard extends Card
{
    public function contentType(): string
    {
        return ContentTypes::AUDIO;
    }
}
