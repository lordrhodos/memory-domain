<?php declare(strict_types=1);

namespace Memory;

use InvalidArgumentException;
use Memory\Card\Content\ImageContent;
use Ramsey\Uuid\Uuid;

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

        if ($this->containsDuplicateCard(...$pairs)) {
            throw new InvalidArgumentException('duplicate card detected');
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
     * @return ImageContent[]
     */
    public function getCards(): array
    {
        $cards = [];
        foreach ($this->pairs as $pair) {
            $cards = array_merge($cards, $pair->getCards());
        }

        return $cards;
    }

    public function makeMove(string $firstCardId, string $secondCardId): void
    {
        $this->validateCardIds($firstCardId, $secondCardId);
    }

    private function validateCardIds(string $firstCardId, string $secondCardId)
    {
        if (Uuid::isValid($firstCardId) || Uuid::isValid($secondCardId)) {
            throw new InvalidArgumentException('ids need to be valid uuids');
        }
    }

    private function containsDuplicateCard(Pair ...$pairs): bool
    {
        $ids = [];
        foreach ($pairs as $pair) {
            foreach ($pair->getCards() as $card) {
                $cardId = $card->id()->id();
                if (in_array($cardId, $ids)) {
                    return true;
                }

                $ids[] = $cardId;
            }
        }

        return false;
    }
}
