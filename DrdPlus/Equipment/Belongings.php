<?php
namespace DrdPlus\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrineum\Entity\Entity;
use DrdPlus\Equipment\Partials\WithWeight;
use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use Granam\Strict\Object\StrictObject;

/**
 * @ORM\Entity()
 */
class Belongings extends StrictObject implements WithWeight, Entity, \Countable, \IteratorAggregate
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="\DrdPlus\Equipment\Item",mappedBy="belongings",fetch="EAGER")
     */
    protected $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return bool if has not been contained and was added
     */
    public function addItem(Item $item)
    {
        $wasAdded = $this->items->add($item);
        if ($item->getBelongings() !== $this) {
            $item->setBelongings($this);
        }

        return $wasAdded;
    }

    /**
     * @param Item $item
     * @return bool if has been contained and removed
     */
    public function removeItem(Item $item)
    {
        return $this->items->removeElement($item);
    }

    /**
     * @param WeightTable $weightTable
     * @return Weight
     */
    public function getWeight(WeightTable $weightTable)
    {
        return new Weight(
            array_sum(
                array_map(
                    function (Item $item) use ($weightTable) {
                        return $item->getWeight($weightTable)->getValue();
                    },
                    $this->getItems()
                )
            ),
            Weight::KG,
            $weightTable
        );
    }
}