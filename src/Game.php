<?php declare(strict_types=1);

namespace Memory;

use InvalidArgumentException;
use Memory\Contracts\Card;
use Ramsey\Uuid\Uuid;

class Game
{
    /**
     * @var string[]
     */
    private $pairedIds;

    /**
     * @var Card[]
     */
    private $cards;

    /**
     * @var Card[]
     */
    private $matchedCards;

    /**
     * @var string[]
     */
    private $moves;

    /**
     * @var float
     */
    private $startedAt;

    /**
     * @var float
     */
    private $stoppedAt;

    public function __construct(Pair ...$pairs)
    {
        if (count($pairs) < 2) {
            throw new InvalidArgumentException('you need to define at least two pair of cards to create a game');
        }

        if ($this->containsDuplicateCard(...$pairs)) {
            throw new InvalidArgumentException('duplicate card detected');
        }

        $this->pairedIds = $this->getPairedIds(...$pairs);
        $this->cards = $this->getCardsFromPairs(...$pairs);
        $this->matchedCards = [];
        $this->moves = [];
    }

    public function countCards(): int
    {
        return count($this->cards);
    }

    public function countMoves()
    {
        return count($this->moves);
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
        return array_diff($this->cards, $this->matchedCards);
    }

    public function makeMove(string $firstCardId, string $secondCardId): bool
    {
        if ($this->isFirstMove()) {
            $this->startTiming();
        }
        $this->logMove($firstCardId, $secondCardId);
        $this->validateCardIds($firstCardId, $secondCardId);

        if ($this->cardsMatch($firstCardId, $secondCardId)) {
            $this->addCardsToMatched($firstCardId, $secondCardId);
            if ($this->isLastMatch()) {
                $this->stopTiming();
            }
            return true;
        }

        return false;
    }

    private function validateCardIds(string $firstCardId, string $secondCardId): void
    {
        $this->idsAreValidUuids($firstCardId, $secondCardId);
        $this->idsExist($firstCardId, $secondCardId);
        $this->idsAreUnmatched($firstCardId, $secondCardId);
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
        if (array_key_exists($firstCardId, $this->pairedIds) && $this->pairedIds[$firstCardId] === $secondCardId) {
            return true;
        }

        $flipped = array_flip($this->pairedIds);

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
            $firstId = $firstCard->id()->__toString();
            $secondId = $secondCard->id()->__toString();
            $paired[$firstId] = $secondId;
        }

        return $paired;
    }

    private function idsAreValidUuids(string $firstCardId, string $secondCardId): void
    {
        if (!Uuid::isValid($firstCardId) || !Uuid::isValid($secondCardId)) {
            throw new InvalidArgumentException('ids need to be valid uuids');
        }
    }

    private function idsExist(string $firstCardId, string $secondCardId): void
    {
        if (!$this->idExists($firstCardId) || !$this->idExists($secondCardId)) {
            throw new InvalidArgumentException("one or both ids do not exist");
        }
    }

    private function idsAreUnmatched(string $firstCardId, string $secondCardId): void
    {
        if (!$this->idIsUnmatched($firstCardId) || !$this->idIsUnmatched($secondCardId)) {
            throw new InvalidArgumentException("one or both ids are matched already");
        }
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

    private function idIsUnmatched(string $firstCardId): bool
    {
        return !array_key_exists($firstCardId, $this->matchedCards);
    }

    private function idExists(string $cardId)
    {
        return array_key_exists($cardId, $this->cards);
    }

    private function logMove(string $firstCardId, string $secondCardId): void
    {
        $this->moves[] = [$firstCardId, $secondCardId];
    }

    public function timeSpent(): float
    {
        if ($this->startedAt === null) {
            return 0.0;
        }

        if ($this->stoppedAt === null) {
            return microtime(true) - $this->startedAt;
        }

        return $this->stoppedAt - $this->startedAt;
    }

    private function isFirstMove(): bool
    {
        return empty($this->moves);
    }

    private function startTiming()
    {
        $this->startedAt = microtime(true);
    }

    private function stopTiming()
    {
        $this->stoppedAt = microtime(true);
    }

    private function isLastMatch()
    {
        $matchedCardsCount = count($this->matchedCards);
        $cardCount = count($this->cards);
        if ($matchedCardsCount === $cardCount) {
            return true;
        }

        return false;
    }
}
