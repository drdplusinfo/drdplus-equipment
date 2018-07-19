<?php
declare(strict_types = 1);

namespace DrdPlus\Tests\Equipment\Partials;

use DrdPlus\Equipment\Partials\WithWeight;

/**
 * @method static assertTrue(bool $condition)
 * @method string getSutClass
 */
trait WithWeightTest
{
    /**
     * @test
     */
    public function It_has_with_weight_interface()
    {
        self::assertTrue(is_a($this->getSutClass(), WithWeight::class, true /* no instance needed */));
    }
}