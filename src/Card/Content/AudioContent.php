<?php declare(strict_types=1);

namespace Memory\Card\Content;

use Memory\Contracts\ContentTypes;

class AudioContent extends Content
{
    public function contentType(): string
    {
        return ContentTypes::AUDIO;
    }
}
