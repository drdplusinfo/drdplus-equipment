<?php
namespace DrdPlus\Equipment\EnumTypes;

use DrdPlus\Codes\Armaments\EnumTypes\BodyArmorCodeType;
use DrdPlus\Codes\Armaments\EnumTypes\HelmCodeType;
use DrdPlus\Codes\Armaments\EnumTypes\WeaponlikeCodeType;
use DrdPlus\Properties\Body\EnumTypes\WeightInKgType;
use Granam\Strict\Object\StrictObject;

class EquipmentEnumsRegistrar extends StrictObject
{
    public static function registerAll()
    {
        WeightInKgType::registerSelf();
        WeaponlikeCodeType::registerSelf();
        BodyArmorCodeType::registerSelf();
        HelmCodeType::registerSelf();
    }

}