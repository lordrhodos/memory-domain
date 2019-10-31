<?php declare(strict_types=1);

namespace Memory;

use Memory\Card\Card;
use Memory\Card\CardId;
use Memory\Card\DecoratedCard;
use Ramsey\Uuid\UuidInterface;

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
}
