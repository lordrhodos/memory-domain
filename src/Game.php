<?php declare(strict_types=1);

namespace Memory;

use InvalidArgumentException;
use Memory\Contracts\Card;
use Ramsey\Uuid\Uuid;

class Game
{
    private const DEFAULT_NUMBER_OF_CARDS = 16;

    /**
     * @var string[]
     */
    private $pairs;

    /**
     * @var Card[]
     */
    private $cards;

    /**
     * @var Card[]
     */
    private $matchedCards;

    /**
     * @var Card[]
     */
    private $unmatchedCards;

    public function __construct(Pair ...$pairs)
    {
        if (count($pairs) < 2) {
            throw new InvalidArgumentException('you need to define at least two pair of cards to create a game');
        }

        if ($this->containsDuplicateCard(...$pairs)) {
            throw new InvalidArgumentException('duplicate card detected');
        }

        $this->pairs = $this->getPairedIds(...$pairs);
        $this->cards = $this->getCardsFromPairs(...$pairs);
        $this->matchedCards = [];
        $this->unmatchedCards = $this->cards;
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
     * @return Card[]
     */
    public function cards(): array
    {
        return $this->cards;
    }

    public function matchedCards(): array
    {
        return $this->matchedCards;
    }

    public function unmatchedCards(): array
    {
        return $this->unmatchedCards;
    }

    public function makeMove(string $firstCardId, string $secondCardId): bool
    {
        $this->validateCardIds($firstCardId, $secondCardId);

        if ($this->cardsMatch($firstCardId, $secondCardId)) {
            $this->removeFromUnmatched($firstCardId, $secondCardId);
            $this->addCardsToMatched($firstCardId, $secondCardId);
        }

        return false;
    }

    private function validateCardIds(string $firstCardId, string $secondCardId)
    {
        $this->idsAreValidUuids($firstCardId, $secondCardId);
        $this->idsExist($firstCardId, $secondCardId);
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

    /**
     * @return Card[]
     */
    private function getCardsFromPairs(Pair ...$pairs): array
    {
        $cards = [];
        foreach ($pairs as $pair) {
            foreach ($pair->getCards() as $card) {
                $cardId = $card->id()->__toString();
                $cards[$cardId] = $card;
            }
        }

        return $cards;
    }

    private function cardsMatch(string $firstCardId, string $secondCardId): bool
    {
        if (array_key_exists($firstCardId, $this->pairs) && $this->pairs[$firstCardId] === $secondCardId) {
            return true;
        }

        $flipped = array_flip($this->pairs);

        if (array_key_exists($firstCardId, $flipped) && $flipped[$firstCardId] === $secondCardId) {
            return true;
        }

        return false;
    }

    /**
     * @return string[]
     */
    private function getPairedIds(Pair ...$pairs): array
    {
        $paired = [];
        foreach ($pairs as $pair) {
            [$firstCard, $secondCard] = $pair->getCards();
            $paired[$firstCard->id()->__toString()] = $secondCard->id()->__toString();
        }

        return $paired;
    }

    private function idsAreValidUuids(string $firstCardId, string $secondCardId): void
    {
        if (!Uuid::isValid($firstCardId) || !Uuid::isValid($secondCardId)) {
            throw new InvalidArgumentException('ids need to be valid uuids');
        }
    }

    private function idsExist(string $firstCardId, string $secondCardId)
    {
        return array_key_exists($firstCardId, $this->cards) && array_key_exists($secondCardId, $this->cards);
    }

    private function removeFromUnmatched(string $firstCardId, string $secondCardId): void
    {
        unset($this->unmatchedCards[$firstCardId]);
        unset($this->unmatchedCards[$secondCardId]);
    }

    private function addCardsToMatched(string $firstCardId, string $secondCardId)
    {
        $this->addCardToMatched($firstCardId);
        $this->addCardToMatched($secondCardId);
    }

    private function addCardToMatched(string $cardId): void
    {
        $card = $this->cards[$cardId];
        $this->matchedCards[$cardId] = $card;
    }
}
