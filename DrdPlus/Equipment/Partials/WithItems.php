<?php
namespace DrdPlus\Equipment\Partials;

use DrdPlus\Equipment\Item;

interface WithItems extends \Countable, \IteratorAggregate
{
    /**
     * @param Item $item
     * @return bool if has not been contained and was added
     */
    public function addItem(Item $item);

    /**
     * @param Item $item
     * @return bool if has been contained and removed
     */
    public function removeItem(Item $item);

}