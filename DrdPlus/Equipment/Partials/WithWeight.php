<?php
namespace DrdPlus\Equipment\Partials;

use DrdPlus\Properties\Body\WeightInKg;

interface WithWeight
{
    /**
     * @return WeightInKg
     */
    public function getWeightInKg();
}