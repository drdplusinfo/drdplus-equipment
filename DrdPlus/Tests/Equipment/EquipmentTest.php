<?php
namespace DrdPlus\Tests\Equipment;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Equipment\Belongings;
use DrdPlus\Equipment\Equipment;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tests\Equipment\Partials\WithWeightTest;
use Granam\Tests\Tools\TestWithMockery;

class EquipmentTest extends TestWithMockery
{
    use WithWeightTest;

    /**
     * @test
     */
    public function I_can_use_it()
    {
        $equipment = new Equipment(
            $belongings = $this->createBelongings($weight = $this->createWeight(123.789)),
            $bodyArmorCode = BodyArmorCode::getIt(BodyArmorCode::HOBNAILED_ARMOR),
            $helmCode = HelmCode::getIt(HelmCode::CONICAL_HELM),
            $mainHand = RangedWeaponCode::getIt(RangedWeaponCode::LIGHT_CROSSBOW),
            $offhand = ShieldCode::getIt(ShieldCode::PAVISE)
        );
        self::assertNull($equipment->getId());
        self::assertSame($belongings, $equipment->getBelongings());
        $weightTable = new WeightTable();
        self::assertSame($belongings->getWeight($weightTable), $equipment->getWeight($weightTable));

        self::assertSame($bodyArmorCode, $equipment->getWornBodyArmor());
        $anotherBodyArmorCode = BodyArmorCode::getIt(BodyArmorCode::WITHOUT_ARMOR);
        $equipment->setWornBodyArmor($anotherBodyArmorCode);
        self::assertSame($anotherBodyArmorCode, $equipment->getWornBodyArmor());

        self::assertSame($helmCode, $equipment->getWornHelm());
        $anotherHelmCode = HelmCode::getIt(HelmCode::LEATHER_CAP);
        $equipment->setWornHelm($anotherHelmCode);
        self::assertSame($anotherHelmCode, $equipment->getWornHelm());

        self::assertSame($mainHand, $equipment->getWeaponOrShieldInMainHand());
        $anotherMainHand = ShieldCode::getIt(ShieldCode::MEDIUM_SHIELD);
        $equipment->setWeaponOrShieldInMainHand($anotherMainHand);
        self::assertSame($anotherMainHand, $equipment->getWeaponOrShieldInMainHand());

        self::assertSame($offhand, $equipment->getWeaponOrShieldInOffhand());
        $anotherOffhand = ShieldCode::getIt(ShieldCode::WITHOUT_SHIELD);
        $equipment->setWeaponOrShieldInOffhand($anotherOffhand);
        self::assertSame($anotherOffhand, $equipment->getWeaponOrShieldInOffhand());
    }

    /**
     * @param Weight $weight
     * @return \Mockery\MockInterface|Belongings
     */
    private function createBelongings(Weight $weight)
    {
        $belongings = $this->mockery(Belongings::class);
        $belongings->shouldReceive('getWeight')
            ->with($this->type(WeightTable::class))
            ->andReturn($weight);

        return $belongings;
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Weight
     */
    private function createWeight($value)
    {
        $weight = $this->mockery(Weight::class);
        $weight->shouldReceive('getValue')
            ->andReturn($value);

        return $weight;
    }
}
