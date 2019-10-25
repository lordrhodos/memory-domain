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
    private $uuid;

    public function __construct(Card $card)
    {
        $this->card = $card;
        $this->uuid = Uuid::uuid4()->__toString();
    }

    public function getId(): string
    {
        return $this->uuid;
    }

    public function getCardId(): string
    {
        return $this->card->getId();
    }

    public function getTitle(): string
    {
        return $this->card->getTitle();
    }

    public function getContent(): string
    {
        return $this->card->getContent();
    }

    public function getContentType(): string
    {
        return $this->card->getContentType();
    }
}
