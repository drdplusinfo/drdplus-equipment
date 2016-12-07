<?php
namespace DrdPlus\Tests\Equipment;

use DrdPlus\Equipment\Item;
use DrdPlus\Equipment\Partials\WithItems;
use DrdPlus\Properties\Body\WeightInKg;
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
        $item = new Item('foo', $weightInKg = $this->createWeightInKg());
        self::assertNull($item->getId());
        self::assertSame('foo', $item->getName());
        self::assertSame('foo', (string)$item);
        self::assertSame($weightInKg, $item->getWeightInKg());
        self::assertNull($item->getContainerWithThisItem());
    }

    /**
     * @test
     */
    public function I_can_set_and_change_container()
    {
        $item = new Item('foo', $this->createWeightInKg());
        self::assertNull($item->getContainerWithThisItem());
        $item->setContainer($containerWithItems = $this->createContainerWithItems());
        self::assertSame($containerWithItems, $item->getContainerWithThisItem());
        $item->setContainer($containerWithItems = $this->createContainerWithItems());
        self::assertSame($containerWithItems, $item->getContainerWithThisItem());
        $item->setContainer($anotherContainerWithItems = $this->createContainerWithItems());
        self::assertNotSame($containerWithItems, $item->getContainerWithThisItem());
        self::assertSame($anotherContainerWithItems, $item->getContainerWithThisItem());
    }

    /**
     * @return \Mockery\MockInterface|WeightInKg
     */
    private function createWeightInKg()
    {
        return $this->mockery(WeightInKg::class);
    }

    /**
     * @test
     */
    public function I_can_create_it_with_container()
    {
        $item = new Item(
            'foo',
            $weightInKg = $this->createWeightInKg(),
            $containerWithItems = $this->createContainerWithItems()
        );
        self::assertNull($item->getId());
        self::assertSame('foo', $item->getName());
        self::assertSame('foo', (string)$item);
        self::assertSame($weightInKg, $item->getWeightInKg());
        self::assertSame($containerWithItems, $item->getContainerWithThisItem());
        $item->setContainer($containerWithItems);
        self::assertSame($containerWithItems, $item->getContainerWithThisItem());
    }

    /**
     * @return \Mockery\MockInterface|WithItems
     */
    private function createContainerWithItems()
    {
        $withItems = $this->mockery(WithItems::class);
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
        new Item('', $this->createWeightInKg());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Equipment\Exceptions\ItemNameIsTooLong
     * @expectedExceptionMessageRegExp ~aaab~
     */
    public function I_can_not_create_it_with_extremely_long_name()
    {
        $nameReflection = new \ReflectionProperty(Item::class, 'name');
        self::assertGreaterThan(0, preg_match('~length=(?<maxLength>\d+)~', $nameReflection->getDocComment(), $matches));
        $maxLength = $matches['maxLength'];
        self::assertGreaterThan(0, $maxLength);

        $veryLongName = str_repeat('a', $maxLength);
        try {
            new Item($veryLongName, $this->createWeightInKg());
        } catch (\Exception $exception) {
            self::fail('No exception expected so far: ' . $exception->getMessage());
        }

        $tooLongName = $veryLongName . 'b';
        new Item($tooLongName, $this->createWeightInKg());
    }
}