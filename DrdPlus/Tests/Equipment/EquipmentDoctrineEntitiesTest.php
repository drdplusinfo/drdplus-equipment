<?php
namespace DrdPlus\Tests\Equipment;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Equipment\Belongings;
use DrdPlus\Equipment\EnumTypes\EquipmentEnumsRegistrar;
use DrdPlus\Equipment\Equipment;
use DrdPlus\Equipment\Item;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;

class EquipmentDoctrineEntitiesTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        EquipmentEnumsRegistrar::registerAll();
        parent::setUp();
    }

    protected function getDirsWithEntities()
    {
        return __DIR__ . '/../../Equipment';
    }

    protected function createEntitiesToPersist()
    {
        $weightTable= new WeightTable();
        $item1 = new Item('foo', new Weight(78.123, Weight::KG, $weightTable));

        $belongings = new Belongings();
        $item2 = new Item('bar', new Weight(99, Weight::KG, $weightTable));
        $belongings->addItem($item2);

        $equipment = new Equipment(
            $belongings,
            BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR),
            HelmCode::getIt(HelmCode::CHAINMAIL_HOOD),
            MeleeWeaponCode::getIt(MeleeWeaponCode::BOWIE_KNIFE),
            RangedWeaponCode::getIt(RangedWeaponCode::JAVELIN)
        );

        return [
            $item1,
            $item2,
            $belongings,
            $equipment
        ];
    }

}