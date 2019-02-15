<?php
declare(strict_types=1);

namespace DrdPlus\Tests\Equipment;

use DrdPlus\Equipment\Belongings;
use DrdPlus\Equipment\Item;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tests\Equipment\Partials\WithWeightTest;
use Granam\Tests\Tools\TestWithMockery;

class ItemTest extends TestWithMockery
{
    use WithWeightTest;

    /**
     * @test
     */
    public function I_can_create_it_without_any_container()
    {
        $item = new Item('foo', $weight = $this->createWeight());
        self::assertSame('foo', $item->getName());
        self::assertSame('foo', (string)$item);
        self::assertSame($weight, $item->getWeight(new WeightTable()));
        self::assertNull($item->getBelongings());
    }

    /**
     * @test
     */
    public function I_can_set_and_change_container()
    {
        $item = new Item('foo', $this->createWeight());
        self::assertNull($item->getBelongings());
        $item->setBelongings($belongings = $this->createBelongings());
        self::assertSame($belongings, $item->getBelongings());
        $item->setBelongings($belongings = $this->createBelongings());
        self::assertSame($belongings, $item->getBelongings());
        $item->setBelongings($anotherBelongings = $this->createBelongings());
        self::assertNotSame($belongings, $item->getBelongings());
        self::assertSame($anotherBelongings, $item->getBelongings());
    }

    /**
     * @param float $kilograms
     * @return \Mockery\MockInterface|Weight
     */
    private function createWeight($kilograms = 123.456)
    {
        $weight = $this->mockery(Weight::class);
        $weight->shouldReceive('getKilograms')
            ->andReturn($kilograms);

        return $weight;
    }

    /**
     * @test
     */
    public function I_can_create_it_with_container()
    {
        $item = new Item(
            'foo',
            $weight = $this->createWeight(),
            $belongings = $this->createBelongings()
        );
        self::assertSame('foo', $item->getName());
        self::assertSame('foo', (string)$item);
        self::assertSame($weight, $item->getWeight(new WeightTable()));
        self::assertSame($belongings, $item->getBelongings());
        $item->setBelongings($belongings);
        self::assertSame($belongings, $item->getBelongings());
    }

    /**
     * @return \Mockery\MockInterface|Belongings
     */
    private function createBelongings()
    {
        $withItems = $this->mockery(Belongings::class);
        $withItems->shouldReceive('addItem')
            ->with(\Mockery::type(Item::class));

        return $withItems;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Equipment\Exceptions\ItemNameCanNotBeEmpty
     */
    public function I_can_not_create_it_with_empty_name()
    {
        new Item('', $this->createWeight());
    }
}