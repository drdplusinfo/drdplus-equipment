<?php
namespace DrdPlus\Equipment;

use DrdPlus\Equipment\Partials\WithItems;
use DrdPlus\Properties\Body\WeightInKg;
use Granam\Tests\Tools\TestWithMockery;

class BelongingsTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_add_and_remove_item()
    {
        $belongings = new Belongings();
        self::assertNull($belongings->getId());
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
        $item->shouldReceive('getContainerWithThisItem')
            ->andReturn($alreadyPairedWith ? $expectedBelongings : $this->mockery(WithItems::class));
        if (!$alreadyPairedWith) {
            $item->shouldReceive('setContainer')
                ->with($expectedBelongings);
        }
        if ($weightValue !== null) {
            $item->shouldReceive('getWeightInKg')
                ->andReturn(WeightInKg::getIt($weightValue));
        }

        return $item;
    }

    /**
     * @test
     */
    public function I_can_get_weight_of_items()
    {
        $belongings = new Belongings();
        self::assertSame(WeightInKg::getIt(0.0), $belongings->getWeightInKg());
        $belongings->addItem($this->createItem($belongings, true, 123.456));
        self::assertSame(WeightInKg::getIt(123.456), $belongings->getWeightInKg());
        $belongings->addItem($this->createItem($belongings, true, 7193.41));
        self::assertSame(WeightInKg::getIt(123.456 + 7193.41), $belongings->getWeightInKg());
    }
}
