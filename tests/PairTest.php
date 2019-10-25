<?php declare(strict_types=1);

namespace Memory\Test;

use InvalidArgumentException;
use Memory\Card;
use Memory\Pair;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PairTest extends TestCase
{
    public function test_is_instantiable(): void
    {
        $cardMock = $this->createMock(Card::class);
        $cardMock->method('getId')->willReturn('foo');

        $secondCardMock = $this->createMock(Card::class);
        $secondCardMock->method('getId')->willReturn('bar');

        $pair = new Pair($cardMock, $secondCardMock);
        $this->assertInstanceOf(Pair::class, $pair);
    }

    /**
     * @dataProvider provide_invalid_number_of_cards
     */
    public function test_create_pair_with_invalid_number_of_cards_throws_exception(int $numberOfCards): void
    {
        $cards = [];
        $cardMock = $this->createMock(Card::class);
        for ($index = 1; $index <= $numberOfCards; $index++) {
            $cards[] = $cardMock;
        }
        $this->expectException(InvalidArgumentException::class);
        new Pair(...$cards);
    }

    public function provide_invalid_number_of_cards(): array
    {
       return [
           [0],
           [1],
           [3],
           [4],
           [5],
           [6],
           [7],
           [8],
           [9],
           [999],
       ];
    }

    public function test_create_pair_with_cards_with_identical_id_throws_exception(): void
    {
        $cardMock = $this->createMock(Card::class);
        $cardMock->method('getId')->willReturn(Uuid::NIL);

        $this->expectException(InvalidArgumentException::class);
        new Pair($cardMock, $cardMock);
    }

}
