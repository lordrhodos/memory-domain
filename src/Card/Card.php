<?php declare(strict_types=1);

namespace Memory\Card;

use Memory\Contracts\Card as CardContract;

abstract class Card implements CardContract
{
    /**
     * @var CardId
     */
    private $id;

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
        $this->id = $this->createUniqueId();
        $this->title = $title;
        $this->content = $content;
    }

    private function createUniqueId(): CardId
    {
        return new CardId();
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    abstract public function contentType(): string;
}
