<?php
namespace DrdPlus\Equipment\Partials;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrineum\Entity\Entity;
use DrdPlus\Equipment\Item;
use Doctrine\ORM\Mapping as ORM;
use Granam\Strict\Object\StrictObject;

/**
 * @ORM\MappedSuperclass()
 */
abstract class WithItems extends StrictObject implements Entity, \Countable, \IteratorAggregate
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
    protected $items;

    protected function __construct()
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
        if ($item->getContainerWithThisItem() !== $this) {
            $item->setContainer($this);
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

}