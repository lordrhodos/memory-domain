<?php declare(strict_types=1);

namespace Memory;

use Memory\Card\DecoratedCard;
use Memory\Card\ImageCard;
use Memory\Contracts\Card;

class Pair
{
    /**
     * @var DecoratedCard
     */
    private $firstCard;

    /**
     * @var DecoratedCard
     */
    private $secondCard;

    public function __construct(DecoratedCard $firstCard, DecoratedCard $secondCard)
    {
        $this->firstCard = $firstCard;
        $this->secondCard = $secondCard;
    }

    /**
     * @return DecoratedCard[]
     */
    public function getCards(): array
    {
        return [$this->firstCard, $this->secondCard];
    }

    public function matchesIds(string $firstId, string $secondId): bool
    {
        return $this->has($firstId) && $this->has($secondId);
    }

    private function has(string $id): bool
    {
        return $this->firstCardMatchesId($id) || $this->secondCardMatchesId($id);
    }

    private function firstCardMatchesId(string $id): bool
    {
        return $this->firstCard->getId() === $id;
    }

    private function secondCardMatchesId(string $id): bool
    {
        return $this->secondCard->getId() === $id;
    }
}
