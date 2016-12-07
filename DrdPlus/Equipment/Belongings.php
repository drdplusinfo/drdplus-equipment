<?php
namespace DrdPlus\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrineum\Entity\Entity;
use DrdPlus\Equipment\Partials\WithItems;
use DrdPlus\Equipment\Partials\WithWeight;
use DrdPlus\Properties\Body\WeightInKg;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;

class Belongings extends StrictObject implements Entity, WithWeight, WithItems
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Item",mappedBy="containerWithThisItem",fetch="EAGER")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function addItem(Item $item)
    {
        $added = $this->items->add($item);
        if ($item->getContainerWithThisItem() !== $this) {
            $item->setContainer($this);
        }

        return $added;
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
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function removeItem(Item $item)
    {
        return $this->items->removeElement($item);
    }
}