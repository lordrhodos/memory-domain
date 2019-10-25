<?php declare(strict_types=1);

namespace Memory;

use InvalidArgumentException;
use Memory\Card\ImageCard;

class Game
{
    private const DEFAULT_NUMBER_OF_CARDS = 16;

    /**
     * @var Pair[]
     */
    private $pairs;

    public function __construct(Pair ...$pairs)
    {
        if (count($pairs) < 2) {
            throw new InvalidArgumentException('you need to define at least two pair of cards to create a game');
        }

        $this->pairs = $pairs;
    }

    public function getNumberOfCards(): int
    {
        return $this->countCards();
    }

    private function countCards(): int
    {
        return $this->countPairs() * 2;
    }

    private function countPairs(): int
    {
        return count($this->pairs);
    }

    /**
     * @return ImageCard[]
     */
    public function getCards(): array
    {
        $cards = [];
        foreach ($this->pairs as $pair) {
            $cards = array_merge($cards, $pair->getCards());
        }

        return $cards;
    }
}
