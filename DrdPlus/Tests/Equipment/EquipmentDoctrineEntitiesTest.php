<?php
namespace DrdPlus\Tests\Equipment;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Equipment\Belongings;
use DrdPlus\Equipment\Equipment;
use DrdPlus\Equipment\EquipmentEnumsRegistrar;
use DrdPlus\Equipment\Item;
use DrdPlus\Properties\Body\WeightInKg;

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
        $item1 = new Item('foo', WeightInKg::getIt(78.123));

        $belongings = new Belongings();
        $item2 = new Item('bar', WeightInKg::getIt(99));
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