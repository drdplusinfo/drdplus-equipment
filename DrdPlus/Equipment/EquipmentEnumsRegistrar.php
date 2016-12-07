<?php
namespace DrdPlus\Equipment;

use DrdPlus\Properties\Body\EnumTypes\WeightInKgType;
use Granam\Strict\Object\StrictObject;

class EquipmentEnumsRegistrar extends StrictObject
{
    public static function registerAll()
    {
        WeightInKgType::registerSelf();
    }

}