<?php
declare(strict_types=1);

namespace DrdPlus\Equipment;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\Armaments\WeaponlikeCode;
use DrdPlus\Equipment\Partials\WithWeight;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use Granam\Strict\Object\StrictObject;

class Equipment extends StrictObject implements WithWeight
{
    /**
     * @var Belongings
     */
    private $belongings;
    /**
     * @var BodyArmorCode
     */
    private $wornBodyArmor;
    /**
     * @var HelmCode
     */
    private $wornHelm;
    /**
     * @var WeaponlikeCode
     */
    private $weaponOrShieldInMainHand;
    /**
     * @var WeaponlikeCode
     */
    private $weaponOrShieldInOffhand;

    /**
     * Weight of worn armor, weapon and shield is NOT counted, see PPH page 114 left column.
     *
     * @param Belongings $belongings
     * @param BodyArmorCode $wornBodyArmor use @see BodyArmorCode::WITHOUT_ARMOR for no armor
     * @param HelmCode $wornHelm use @see HelmCode::WITHOUT_HELM for no helm
     * @param WeaponlikeCode $weaponlikeInMainHand use @see \DrdPlus\Codes\Armaments\MeleeWeaponCode::HAND
     * or @see \DrdPlus\Codes\Armaments\ShieldCode::WITHOUT_SHIELD for empty main hand
     * @param WeaponlikeCode $weaponlikeInOffhand use @see \DrdPlus\Codes\Armaments\MeleeWeaponCode::HAND
     * or @see \DrdPlus\Codes\Armaments\ShieldCode::WITHOUT_SHIELD for empty offhand
     */
    public function __construct(
        Belongings $belongings,
        BodyArmorCode $wornBodyArmor,
        HelmCode $wornHelm,
        WeaponlikeCode $weaponlikeInMainHand,
        WeaponlikeCode $weaponlikeInOffhand
    )
    {
        $this->belongings = $belongings;
        $this->wornBodyArmor = $wornBodyArmor;
        $this->wornHelm = $wornHelm;
        $this->weaponOrShieldInMainHand = $weaponlikeInMainHand;
        $this->weaponOrShieldInOffhand = $weaponlikeInOffhand;
    }

    /**
     * Note: weight of worn armor, weapon and shield is NOT counted, see PPH page 114 left column.
     *
     * @param WeightTable $weightTable
     * @return Weight
     */
    public function getWeight(WeightTable $weightTable): Weight
    {
        return $this->getBelongings()->getWeight($weightTable);
    }

    public function getBelongings(): Belongings
    {
        return $this->belongings;
    }

    public function getWornBodyArmor(): BodyArmorCode
    {
        return $this->wornBodyArmor;
    }

    /**
     * Time to change last year model.
     * Use @see BodyArmorCode::WITHOUT_ARMOR for no armor at all.
     *
     * @param BodyArmorCode $wornBodyArmor
     */
    public function setWornBodyArmor(BodyArmorCode $wornBodyArmor)
    {
        $this->wornBodyArmor = $wornBodyArmor;
    }

    public function getWornHelm(): HelmCode
    {
        return $this->wornHelm;
    }

    /**
     * Time to look more dangerous, less ugly.
     * Use @see HelmCode::WITHOUT_HELM for no helm.
     *
     * @param HelmCode $wornHelm
     */
    public function setWornHelm(HelmCode $wornHelm)
    {
        $this->wornHelm = $wornHelm;
    }

    public function getWeaponOrShieldInMainHand(): WeaponlikeCode
    {
        return $this->weaponOrShieldInMainHand;
    }

    /**
     * Use @see ShieldCode::WITHOUT_SHIELD
     * or @see MeleeWeaponCode::HAND for empty hand
     *
     * @param WeaponlikeCode $weaponOrShieldInMainHand
     */
    public function setWeaponOrShieldInMainHand(WeaponlikeCode $weaponOrShieldInMainHand)
    {
        $this->weaponOrShieldInMainHand = $weaponOrShieldInMainHand;
    }

    public function getWeaponOrShieldInOffhand(): WeaponlikeCode
    {
        return $this->weaponOrShieldInOffhand;
    }

    /**
     * Use @see ShieldCode::WITHOUT_SHIELD
     * or @see MeleeWeaponCode::HAND for empty hand
     *
     * @param WeaponlikeCode $weaponOrShieldInOffhand
     */
    public function setWeaponOrShieldInOffhand(WeaponlikeCode $weaponOrShieldInOffhand)
    {
        $this->weaponOrShieldInOffhand = $weaponOrShieldInOffhand;
    }

}