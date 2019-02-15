<?php
declare(strict_types=1);

namespace DrdPlus\Tests\Equipment;

use DrdPlus\Equipment\Belongings;
use DrdPlus\Equipment\Item;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tests\Equipment\Partials\WithWeightTest;
use Granam\Tests\Tools\TestWithMockery;

class BelongingsTest extends TestWithMockery
{
    use WithWeightTest;

    /**
     * @test
     */
    public function I_can_add_and_remove_item()
    {
        $belongings = new Belongings();
        self::assertCount(0, $belongings);
        $belongings->addItem($item = $this->createItem($belongings, true /* already paired with */));
        self::assertCount(1, $belongings);
        $belongings->addItem($item2 = $this->createItem($belongings, false /* not yet paired with */));
        self::assertCount(2, $belongings);
        $collectedItems = [];
        foreach ($belongings as $belonging) {
            $collectedItems[] = $belonging;
        }
        self::assertSame([$item, $item2], $collectedItems);
        self::assertTrue($belongings->removeItem($item));
        self::assertCount(1, $belongings);
        self::assertCount(1, $belongings->getItems());
        self::assertSame([$item2], array_values($belongings->getItems()));
    }

    /**
     * @param Belongings $expectedBelongings
     * @param bool $alreadyPairedWith
     * @param float|null $weightValue
     * @return \Mockery\MockInterface|Item
     */
    private function createItem(Belongings $expectedBelongings, $alreadyPairedWith, $weightValue = null)
    {
        $item = $this->mockery(Item::class);
        $item->shouldReceive('getBelongings')
            ->andReturn($alreadyPairedWith ? $expectedBelongings : $this->mockery(Belongings::class));
        if (!$alreadyPairedWith) {
            $item->shouldReceive('setBelongings')
                ->with($expectedBelongings);
        }
        if ($weightValue !== null) {
            $item->shouldReceive('getWeight')
                ->with($this->type(WeightTable::class))
                ->andReturn($this->createWeight($weightValue));
        }

        return $item;
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Weight
     */
    private function createWeight($value)
    {
        $weight = $this->mockery(Weight::class);
        $weight->shouldReceive('getValue')
            ->andReturn($value);

        return $weight;
    }

    /**
     * @test
     */
    public function I_can_get_weight_of_items()
    {
        $belongings = new Belongings();
        $weightTable = new WeightTable();
        self::assertEquals(new Weight(0, Weight::KG, $weightTable), $belongings->getWeight($weightTable));
        $belongings->addItem($this->createItem($belongings, true, 123.456));
        self::assertEquals(new Weight(123.456, Weight::KG, $weightTable), $belongings->getWeight($weightTable));
        $belongings->addItem($this->createItem($belongings, true, 7193.41));
        self::assertEquals(new Weight(123.456 + 7193.41, Weight::KG, $weightTable), $belongings->getWeight($weightTable));
    }
}