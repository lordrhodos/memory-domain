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

    public function __construct(ContentId $id, string $title, string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
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

    abstract public function type(): string;
}
