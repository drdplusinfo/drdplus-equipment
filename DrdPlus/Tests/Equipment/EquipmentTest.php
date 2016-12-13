<?php
namespace DrdPlus\Tests\Equipment;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Equipment\Belongings;
use DrdPlus\Equipment\Equipment;
use DrdPlus\Properties\Body\WeightInKg;
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
            $belongings = $this->createBelongings(),
            $bodyArmorCode = BodyArmorCode::getIt(BodyArmorCode::HOBNAILED_ARMOR),
            $helmCode = HelmCode::getIt(HelmCode::CONICAL_HELM),
            $mainHand = RangedWeaponCode::getIt(RangedWeaponCode::LIGHT_CROSSBOW),
            $offhand = ShieldCode::getIt(ShieldCode::PAVISE)
        );
        self::assertNull($equipment->getId());
        self::assertSame($belongings, $equipment->getBelongings());
        self::assertSame($belongings->getWeightInKg(), $equipment->getWeightInKg());

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
     * @return \Mockery\MockInterface|Belongings
     */
    private function createBelongings()
    {
        $belongings = $this->mockery(Belongings::class);
        $belongings->shouldReceive('getWeightInKg')
            ->andReturn($this->mockery(WeightInKg::class));

        return $belongings;
    }
}
