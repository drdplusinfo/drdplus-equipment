<?php
declare(strict_types=1);

namespace DrdPlus\Equipment;

use DrdPlus\Equipment\Partials\WithWeight;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use Granam\Strict\Object\StrictObject;

class Belongings extends StrictObject implements WithWeight, \Countable, \IteratorAggregate
{
    /**
     * @var array|Item[]
     */
    private $items = [];

    /**
     * @return array|Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;
        if ($item->getBelongings() !== $this) {
            $item->setBelongings($this);
        }
    }

    /**
     * @param Item $itemToRemove
     * @return bool if has been contained and removed
     */
    public function removeItem(Item $itemToRemove): bool
    {
        foreach ($this->items as $index => $item) {
            if ($item === $itemToRemove) {
                unset($this->items[$index]);
                return true;
            }
        }
        return false;
    }

    /**
     * @param WeightTable $weightTable
     * @return Weight
     */
    public function getWeight(WeightTable $weightTable): Weight
    {
        return new Weight(
            \array_sum(
                \array_map(
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