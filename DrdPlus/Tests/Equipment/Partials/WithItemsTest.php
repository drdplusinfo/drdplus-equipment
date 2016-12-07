<?php
namespace DrdPlus\Tests\Equipment\Partials;

use DrdPlus\Equipment\Partials\WithItems;

/**
 * @method static assertTrue(bool $condition)
 * @method string getSutClass
 */
trait WithItemsTest
{
    /**
     * @test
     */
    public function It_has_with_items_interface()
    {
        self::assertTrue(is_a($this->getSutClass(), WithItems::class, true /* no instance needed */));
    }
}