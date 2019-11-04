<?php declare(strict_types=1);

namespace Memory\Contracts;

use Memory\Card\CardId;
use Memory\Card\Content\ContentId;

interface Card
{
    public function id(): CardId;

    public function content(): string;

    public function title(): string;

    public function contentId(): ContentId;

    public function contentType(): string;
}
