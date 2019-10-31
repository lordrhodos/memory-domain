<?php declare(strict_types=1);

namespace Memory\Card;

use Memory\Contracts\Card;
use Ramsey\Uuid\Uuid;

class DecoratedCard implements Card
{
    /**
     * @var Card
     */
    private $card;

    /**
     * @var string
     */
    private $id;

    public function __construct(CardId $id, Card $card)
    {
        $this->id = $id;
        $this->card = $card;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function cardId(): CardId
    {
        return $this->card->id();
    }

    public function title(): string
    {
        return $this->card->title();
    }

    public function content(): string
    {
        return $this->card->content();
    }

    public function contentType(): string
    {
        return $this->card->contentType();
    }
}
