<?php
namespace DrdPlus\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrineum\Entity\Entity;
use DrdPlus\Properties\Body\WeightInKg;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;

class Belongings extends StrictObject implements Entity, WithWeight, \IteratorAggregate
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @var Equipment
     * @ORM\OneToOne(targetEntity="Equipment", mappedBy="belongings")
     */
    private $equipment;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Item",mappedBy="containerWithItems",fetch="EAGER")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items->add($item);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
                    $this->items->getIterator()->getArrayCopy()
                )
            )
        );
    }

    /**
     * @return array|Item[]
     */
    public function getItems()
    {
        // gives array copy to avoid changes of original ArrayCollection
        return $this->items->getIterator()->getArrayCopy();
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->items->getIterator();
    }

    /**
     * @return Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

}