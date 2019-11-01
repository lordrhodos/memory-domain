<?php declare(strict_types=1);

namespace Memory\Contracts;

use Memory\Card\Content\ContentId;

interface Content
{
    public function id(): ContentId;

    public function title(): string;

    public function content(): string;

    public function type(): string;
}
