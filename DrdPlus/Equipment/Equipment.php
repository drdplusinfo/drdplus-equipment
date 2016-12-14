<?php
namespace DrdPlus\Equipment;

use Doctrineum\Entity\Entity;
use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\Armaments\WeaponlikeCode;
use DrdPlus\Equipment\Partials\WithWeight;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use Granam\Strict\Object\StrictObject;
use DOctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Equipment extends StrictObject implements Entity, WithWeight
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @var Belongings
     * @ORM\OneToOne(targetEntity="Belongings",fetch="EAGER",orphanRemoval=false)
     */
    private $belongings;
    /**
     * @var BodyArmorCode
     * @ORM\Column(type="body_armor_code")
     */
    private $wornBodyArmor;
    /**
     * @var HelmCode
     * @ORM\Column(type="helm_code")
     */
    private $wornHelm;
    /**
     * @var WeaponlikeCode
     * @ORM\Column(type="weaponlike_code")
     */
    private $weaponOrShieldInMainHand;
    /**
     * @var WeaponlikeCode
     * @ORM\Column(type="weaponlike_code")
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Note: weight of worn armor, weapon and shield is NOT counted, see PPH page 114 left column.
     *
     * @param WeightTable $weightTable
     * @return Weight
     */
    public function getWeight(WeightTable $weightTable)
    {
        return $this->getBelongings()->getWeight($weightTable);
    }

    /**
     * @return Belongings
     */
    public function getBelongings()
    {
        return $this->belongings;
    }

    /**
     * @return BodyArmorCode
     */
    public function getWornBodyArmor()
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

    /**
     * @return HelmCode
     */
    public function getWornHelm()
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

    /**
     * @return WeaponlikeCode
     */
    public function getWeaponOrShieldInMainHand()
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

    /**
     * @return WeaponlikeCode
     */
    public function getWeaponOrShieldInOffhand()
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