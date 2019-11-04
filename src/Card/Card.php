<?php declare(strict_types=1);

namespace Memory\Card;

use Memory\Card\Content\ContentId;
use Memory\Contracts\Content;
use Memory\Contracts\Card as CardContract;

class Card implements CardContract
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Content
     */
    private $content;

    public function __construct(CardId $id, Content $content)
    {
        $this->id = $id;
        $this->content = $content;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function contentId(): ContentId
    {
        return $this->content->id();
    }

    public function title(): string
    {
        return $this->content->title();
    }

    public function content(): string
    {
        return $this->content->content();
    }

    public function contentType(): string
    {
        return $this->content->type();
    }

    public function __clone()
    {
        $this->id = new CardId();
    }
}
