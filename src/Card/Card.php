<?php declare(strict_types=1);

namespace Memory\Card;

use Memory\Contracts\Card as CardContract;
use Ramsey\Uuid\Uuid;

abstract class Card implements CardContract
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    public function __construct(string $title, string $content)
    {
        $this->uuid = $this->createUniqueId();
        $this->title = $title;
        $this->content = $content;
    }

    private function createUniqueId(): string
    {
        return Uuid::uuid4()->__toString();
    }

    public function getId(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    abstract public function getContentType(): string;
}
