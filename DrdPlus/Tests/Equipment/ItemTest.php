<?php
namespace DrdPlus\Tests\Equipment;

use DrdPlus\Equipment\Belongings;
use DrdPlus\Equipment\Item;
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
        self::assertNull($item->getBelongings());
    }

    /**
     * @test
     */
    public function I_can_set_and_change_container()
    {
        $item = new Item('foo', $this->createWeightInKg());
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
            $belongings = $this->createBelongings()
        );
        self::assertNull($item->getId());
        self::assertSame('foo', $item->getName());
        self::assertSame('foo', (string)$item);
        self::assertSame($weightInKg, $item->getWeightInKg());
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