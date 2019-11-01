<?php declare(strict_types=1);

namespace Memory\Card\Content;

use Memory\Contracts\ContentTypes;

class AudioContent extends Content
{
    public function type(): string
    {
        return ContentTypes::AUDIO;
    }
}
