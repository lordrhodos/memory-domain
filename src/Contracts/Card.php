<?php declare(strict_types=1);

namespace Memory\Card;

interface Card
{
    public function getTitle(): string;

    public function getContent(): string;
}
