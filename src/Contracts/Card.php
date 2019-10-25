<?php declare(strict_types=1);

namespace Memory\Contracts;

interface Card
{
    public function getId(): string;

    public function getTitle(): string;

    public function getContent(): string;

    public function getContentType(): string;
}
