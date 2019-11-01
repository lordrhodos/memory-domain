<?php declare(strict_types=1);

namespace Memory\Contracts;

use Memory\Card\CardId;

interface Card
{
    public function id(): CardId;

    public function content(): string;
}
