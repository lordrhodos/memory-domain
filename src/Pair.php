<?php declare(strict_types=1);

namespace Memory;

use InvalidArgumentException;

class Pair
{
    private const REQUIRED_CARD_COUNT = 2;

    /**
     * @var Card[]
     */
    private $cards;

    public function __construct(Card ...$cards)
    {
        if ($this->isValidNumberOfCards(...$cards)) {
            throw new InvalidArgumentException('A pair consists of exactly two cards.');
        }

        if (!$this->cardsHaveDifferentIds(...$cards)) {
            throw new InvalidArgumentException('Cards can not have the same id.');
        }

        $this->setCards(...$cards);
    }

    private function setCards(Card ...$cards): void
    {
        foreach ($cards as $card) {
            $this->cards[$card->getId()] = $card;
        }
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    private function cardsHaveDifferentIds(Card ...$cards): bool
    {
        $firstCard = $cards[0];
        $secondCard = $cards[1];

        return $firstCard->getId() !== $secondCard->getId();
    }

    private function isValidNumberOfCards(Card ...$cards): bool
    {
        return count($cards) !== self::REQUIRED_CARD_COUNT;
    }
}
