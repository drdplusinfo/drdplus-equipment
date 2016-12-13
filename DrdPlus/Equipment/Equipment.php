<?php
namespace DrdPlus\Equipment;

use Doctrineum\Entity\Entity;
use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\Armaments\WeaponlikeCode;
use DrdPlus\Equipment\Partials\WithWeight;
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
    private $bodyArmorCode;
    /**
     * @var HelmCode
     * @ORM\Column(type="helm_code")
     */
    private $helmCode;
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
     * @param BodyArmorCode $bodyArmorCode use @see BodyArmorCode::WITHOUT_ARMOR for no armor
     * @param HelmCode $helmCode use @see HelmCode::WITHOUT_HELM for no helm
     * @param WeaponlikeCode $weaponlikeInMainHand use @see \DrdPlus\Codes\Armaments\MeleeWeaponCode::HAND
     * or @see \DrdPlus\Codes\Armaments\ShieldCode::WITHOUT_SHIELD for empty main hand
     * @param WeaponlikeCode $weaponlikeInOffhand use @see \DrdPlus\Codes\Armaments\MeleeWeaponCode::HAND
     * or @see \DrdPlus\Codes\Armaments\ShieldCode::WITHOUT_SHIELD for empty offhand
     */
    public function __construct(
        Belongings $belongings,
        BodyArmorCode $bodyArmorCode,
        HelmCode $helmCode,
        WeaponlikeCode $weaponlikeInMainHand,
        WeaponlikeCode $weaponlikeInOffhand
    )
    {
        $this->belongings = $belongings;
        $this->bodyArmorCode = $bodyArmorCode;
        $this->helmCode = $helmCode;
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
     * @return \DrdPlus\Properties\Body\WeightInKg
     */
    public function getWeightInKg()
    {
        return $this->getBelongings()->getWeightInKg();
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
    public function getBodyArmorCode()
    {
        return $this->bodyArmorCode;
    }

    /**
     * Time to change last year model.
     * Use @see BodyArmorCode::WITHOUT_ARMOR for no armor at all.
     *
     * @param BodyArmorCode $bodyArmorCode
     */
    public function setBodyArmorCode(BodyArmorCode $bodyArmorCode)
    {
        $this->bodyArmorCode = $bodyArmorCode;
    }

    /**
     * @return HelmCode
     */
    public function getHelmCode()
    {
        return $this->helmCode;
    }

    /**
     * Time to look more dangerous, less ugly.
     * Use @see HelmCode::WITHOUT_HELM for no helm.
     *
     * @param HelmCode $helmCode
     */
    public function setHelmCode(HelmCode $helmCode)
    {
        $this->helmCode = $helmCode;
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