<?php
namespace DrdPlus\Equipment;

use Doctrineum\Entity\Entity;
use DrdPlus\Equipment\Partials\WithItems;
use DrdPlus\Equipment\Partials\WithWeight;
use DrdPlus\Properties\Body\WeightInKg;
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
     * @var WeightInKg
     * @ORM\Column(type="weight_in_kg")
     */
    private $weightInKg;

    /**
     * @var WithItems
     * @ORM\ManyToOne(targetEntity="WithItems",inversedBy="items")
     */
    private $containerWithThisItem;

    /**
     * @param string|StringInterface $name
     * @param WeightInKg $weightInKg
     * @param WithItems|null $containerWithItems
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     * @throws \DrdPlus\Equipment\Exceptions\ItemNameCanNotBeEmpty
     * @throws \DrdPlus\Equipment\Exceptions\ItemNameIsTooLong
     */
    public function __construct($name, WeightInKg $weightInKg, WithItems $containerWithItems = null)
    {
        $name = trim(ToString::toString($name));
        if ($name === '') {
            throw new Exceptions\ItemNameCanNotBeEmpty(
                "Given name of an item of weight {$weightInKg} is empty"
            );
        }
        if (strlen($name) > 256) {
            throw new Exceptions\ItemNameIsTooLong(
                "Maximal length of a name is 256 bytes, Got {$name} of length " . strlen($name)
            );
        }
        $this->name = $name;
        $this->weightInKg = $weightInKg;
        if ($containerWithItems) {
            $containerWithItems->addItem($this);
            $this->containerWithThisItem = $containerWithItems;
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
     * @return WeightInKg
     */
    public function getWeightInKg()
    {
        return $this->weightInKg;
    }

    /**
     * @return WithItems|null
     */
    public function getContainerWithThisItem()
    {
        return $this->containerWithThisItem;
    }

    /**
     * @param WithItems $containerWithThisItem
     */
    public function setContainer(WithItems $containerWithThisItem)
    {
        if ($this->containerWithThisItem !== $containerWithThisItem) {
            $this->containerWithThisItem = $containerWithThisItem;
        }
    }
}