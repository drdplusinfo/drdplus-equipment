<?php
declare(strict_types=1);

namespace DrdPlus\Equipment;

use DrdPlus\Equipment\Partials\WithWeight;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Granam\String\StringInterface;

class Item extends StrictObject implements WithWeight
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var float
     */
    private $weightInKg;
    /**
     * @var Weight
     */
    private $weight;
    /**
     * @var Belongings
     */
    private $belongings;

    /**
     * @param string|StringInterface $name
     * @param Weight $weight
     * @param Belongings|null $containerWithItems
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     * @throws \DrdPlus\Equipment\Exceptions\ItemNameCanNotBeEmpty
     */
    public function __construct($name, Weight $weight, Belongings $containerWithItems = null)
    {
        $name = trim(ToString::toString($name));
        if ($name === '') {
            throw new Exceptions\ItemNameCanNotBeEmpty(
                "Given name of an item of weight {$weight} is empty"
            );
        }
        $this->name = $name;
        $this->weightInKg = $weight->getKilograms(); // just for persistence
        $this->weight = $weight;
        if ($containerWithItems) {
            $containerWithItems->addItem($this);
            $this->belongings = $containerWithItems;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWeight(WeightTable $weightTable): Weight
    {
        if ($this->weight === null) {
            $this->weight = new Weight($this->weightInKg, Weight::KG, $weightTable);
        }

        return $this->weight;
    }

    public function getBelongings(): ?Belongings
    {
        return $this->belongings;
    }

    public function setBelongings(Belongings $belongings)
    {
        $this->belongings = $belongings;
    }
}