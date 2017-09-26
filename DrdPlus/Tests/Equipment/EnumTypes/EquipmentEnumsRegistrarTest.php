<?php
namespace DrdPlus\Tests\Equipment\EnumTypes;

use Doctrine\DBAL\Types\Type;
use Doctrineum\Scalar\ScalarEnumType;
use DrdPlus\Codes\Armaments\EnumTypes\BodyArmorCodeType;
use DrdPlus\Codes\Armaments\EnumTypes\HelmCodeType;
use DrdPlus\Codes\Armaments\EnumTypes\WeaponlikeCodeType;
use DrdPlus\Equipment\EnumTypes\EquipmentEnumsRegistrar;
use DrdPlus\Properties\Body\EnumTypes\BodyWeightInKgType;
use Granam\Tests\Tools\TestWithMockery;

class EquipmentEnumsRegistrarTest extends TestWithMockery
{
    private $previousTypes;
    private $previousSubTypes;

    protected function setUp()
    {
        // remove tested type from registration
        $_typesMap = new \ReflectionProperty(Type::class, '_typesMap');
        $_typesMap->setAccessible(true);
        $this->previousTypes = $_typesMap->getValue();
        $_typesMap->setValue([]);

        // remove any subtypes from registration
        $subTypeEnums = new \ReflectionProperty(ScalarEnumType::class, 'enumSubTypesMap');
        $subTypeEnums->setAccessible(true);
        $this->previousSubTypes = $_typesMap->getValue();
        $subTypeEnums->setValue([]);
        parent::setUp();
    }

    protected function tearDown()
    {
        // restoring original types
        $_typesMap = new \ReflectionProperty(Type::class, '_typesMap');
        $_typesMap->setAccessible(true);
        $_typesMap->setValue($this->previousTypes);

        // restoring original sub-types
        $subTypeEnums = new \ReflectionProperty(ScalarEnumType::class, 'enumSubTypesMap');
        $subTypeEnums->setAccessible(true);
        $subTypeEnums->setValue($this->previousSubTypes);
        parent::tearDown();
    }

    /**
     * @test
     */
    public function I_can_register_all_required_enums_at_once()
    {
        self::assertFalse(Type::hasType(BodyWeightInKgType::BODY_WEIGHT_IN_KG));
        self::assertFalse(Type::hasType(WeaponlikeCodeType::WEAPONLIKE_CODE));
        self::assertFalse(Type::hasType(BodyArmorCodeType::BODY_ARMOR_CODE));
        self::assertFalse(Type::hasType(HelmCodeType::HELM_CODE));
        EquipmentEnumsRegistrar::registerAll();
        self::assertTrue(Type::hasType(BodyWeightInKgType::BODY_WEIGHT_IN_KG));
        self::assertTrue(Type::hasType(WeaponlikeCodeType::WEAPONLIKE_CODE));
        self::assertTrue(Type::hasType(BodyArmorCodeType::BODY_ARMOR_CODE));
        self::assertTrue(Type::hasType(HelmCodeType::HELM_CODE));
    }
}