<?php
namespace DrdPlus\Equipment;

use DrdPlus\Properties\Body\WeightInKg;

interface WithWeight
{
    /**
     * @return WeightInKg
     */
    public function getWeightInKg();
}