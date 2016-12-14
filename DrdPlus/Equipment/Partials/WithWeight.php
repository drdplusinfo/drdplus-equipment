<?php
namespace DrdPlus\Equipment\Partials;

use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;

interface WithWeight
{
    /**
     * @param WeightTable $weightTable
     * @return Weight
     */
    public function getWeight(WeightTable $weightTable);
}