<?php
namespace DrdPlus\Tests\Equipment\Partials;

use DrdPlus\Equipment\Partials\WithItems;
use Granam\Tests\Tools\TestWithMockery;

abstract class WithItemsTest extends TestWithMockery
{
    /**
     * @test
     */
    public function It_has_with_items_interface()
    {
        self::assertTrue(is_a($this->getSutClass(), WithItems::class, true /* no instance needed */));
    }
}