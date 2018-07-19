<?php
declare(strict_types = 1);

namespace DrdPlus\Equipment;

use Doctrineum\Entity\Entity;
use DrdPlus\Equipment\Partials\WithWeight;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;
use Granam\String\StringInterface;

/**
 * @ORM\Entity()
 */
class Item extends StrictObject implements Entity, WithWeight
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     */
    private $name;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $weightInKg;
    /** @var Weight */
    private $weight;
    /**
     * @var Belongings
     * @ORM\ManyToOne(targetEntity="\DrdPlus\Equipment\Belongings",inversedBy="items")
     */
    private $belongings;

    /**
     * @param string|StringInterface $name
     * @param Weight $weight
     * @param Belongings|null $containerWithItems
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     * @throws \DrdPlus\Equipment\Exceptions\ItemNameCanNotBeEmpty
     * @throws \DrdPlus\Equipment\Exceptions\ItemNameIsTooLong
     */
    public function __construct($name, Weight $weight, Belongings $containerWithItems = null)
    {
        $name = trim(ToString::toString($name));
        if ($name === '') {
            throw new Exceptions\ItemNameCanNotBeEmpty(
                "Given name of an item of weight {$weight} is empty"
            );
        }
        if (strlen($name) > 256) {
            throw new Exceptions\ItemNameIsTooLong(
                "Maximal length of a name is 256 bytes, Got {$name} of length " . strlen($name)
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
        return (string)$this->getName();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param WeightTable $weightTable
     * @return Weight
     */
    public function getWeight(WeightTable $weightTable)
    {
        if ($this->weight === null) {
            $this->weight = new Weight($this->weightInKg, Weight::KG, $weightTable);
        }

        return $this->weight;
    }

    /**
     * @return Belongings|null
     */
    public function getBelongings()
    {
        return $this->belongings;
    }

    /**
     * @param Belongings $belongings
     */
    public function setBelongings(Belongings $belongings)
    {
        if ($this->belongings !== $belongings) {
            $this->belongings = $belongings;
        }
    }
}