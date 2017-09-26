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

    protected function createEntitiesToPersist(): array
    {
        $weightTable = new WeightTable();
        $item1 = new Item('foo', new Weight(78.123, Weight::KG, $weightTable));

        $belongings = new Belongings();
        // explicitly new instance of Item to test cascade persist
        $belongings->addItem(new Item('bar', new Weight(99, Weight::KG, $weightTable)));

        $equipment = new Equipment(
            new Belongings(), // explicitly new instance to test cascade persist
            BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR),
            HelmCode::getIt(HelmCode::CHAINMAIL_HOOD),
            MeleeWeaponCode::getIt(MeleeWeaponCode::BOWIE_KNIFE),
            RangedWeaponCode::getIt(RangedWeaponCode::JAVELIN)
        );

        return [
            $item1,
            $belongings,
            $equipment,
        ];
    }

    /**
     * @test
     */
    public function I_can_persist_and_fetch_entities(): array
    {
        $fetchedEntities = parent::I_can_persist_and_fetch_entities();
        /** @var Item[] $items */
        $items = $fetchedEntities[Item::class];
        self::assertNotEmpty($items);
        $weightTable = new WeightTable();
        foreach ($items as $item) {
            $weightInKgProperty = (new \ReflectionClass($item))->getProperty('weightInKg');
            $weightInKgProperty->setAccessible(true);
            $weightInKg = $weightInKgProperty->getValue($item);
            $weight = $item->getWeight($weightTable);
            self::assertInstanceOf(Weight::class, $weight);
            self::assertSame($weightInKg, $weight->getKilograms());
        }

        return $fetchedEntities;
    }
}