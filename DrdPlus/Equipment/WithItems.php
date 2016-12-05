<?php
namespace DrdPlus\Equipment;

interface WithItems extends \Countable, \IteratorAggregate
{
    /**
     * @param Item $item
     */
    public function addItem(Item $item);

    public function removeItem(Item $item);

}