<?php declare(strict_types=1);

namespace Memory\Card\Content;

use Memory\Card\Content\Content;
use Memory\Contracts\ContentTypes;

class VideoContent extends Content
{
    public function type(): string
    {
        return ContentTypes::VIDEO;
    }
}
