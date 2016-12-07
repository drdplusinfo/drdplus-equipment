<?php
namespace DrdPlus\Equipment;

use DrdPlus\Equipment\Partials\WithItems;
use DrdPlus\Equipment\Partials\WithWeight;
use DrdPlus\Properties\Body\WeightInKg;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Belongings extends WithItems implements WithWeight
{
    public function __construct()
    {
        // just making it public
        parent::__construct();
    }

    /**
     * @return WeightInKg
     */
    public function getWeightInKg()
    {
        return WeightInKg::getIt(
            array_sum(
                array_map(
                    function (Item $item) {
                        return $item->getWeightInKg()->getValue();
                    },
                    $this->getItems()
                )
            )
        );
    }
}