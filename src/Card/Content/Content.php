<?php declare(strict_types=1);

namespace Memory\Card\Content;

use Memory\Contracts\Content as CardContract;

abstract class Content implements CardContract
{
    /**
     * @var ContentId
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

    private function createUniqueId(): ContentId
    {
        return new ContentId();
    }

    public function id(): ContentId
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
