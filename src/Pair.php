<?php declare(strict_types=1);

namespace Memory;

use InvalidArgumentException;
use Memory\Card\CardId;
use Memory\Card\Card;

class Pair
{
    /**
     * @var Card
     */
    private $firstCard;

    /**
     * @var Card
     */
    private $secondCard;

    public function __construct(Card $firstCard, Card $secondCard)
    {
        if (!$this->cardsAreUnique($firstCard, $secondCard)) {
            throw new InvalidArgumentException('cards need to be unique');
        }
        $this->firstCard = $firstCard;
        $this->secondCard = $secondCard;
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return [$this->firstCard, $this->secondCard];
    }

    public function matchesIds(CardId $firstId, CardId $secondId): bool
    {
        return $this->has($firstId) && $this->has($secondId);
    }

    private function has(CardId $id): bool
    {
        return $this->firstCardMatchesId($id) || $this->secondCardMatchesId($id);
    }

    private function firstCardMatchesId(CardId $id): bool
    {
        return $this->firstCard->id() === $id;
    }

    private function secondCardMatchesId(CardId $id): bool
    {
        return $this->secondCard->id() === $id;
    }

    private function cardsAreUnique(Card $firstCard, Card $secondCard)
    {
        return $firstCard->id()->__toString() !== $secondCard->id()->__toString();
    }
}
