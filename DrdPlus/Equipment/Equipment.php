<?php
namespace DrdPlus\Equipment;

use Doctrineum\Entity\Entity;
use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\WeaponlikeCode;
use Granam\Strict\Object\StrictObject;
use DOctrine\ORM\Mapping as ORM;

class Equipment extends StrictObject implements Entity, WithWeight
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @var Belongings
     * @ORM\OneToOne(targetEntity="Belongings", inversedBy="equipment")
     */
    private $belongings;
    /**
     * @var BodyArmorCode
     */
    private $bodyArmorCode;
    /**
     * @var HelmCode
     */
    private $helmCode;
    /**
     * @var WeaponlikeCode
     */
    private $weaponlikeInMainHand;
    /**
     * @var WeaponlikeCode
     */
    private $weaponlikeInOffhand;

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
        $this->weaponlikeInMainHand = $weaponlikeInMainHand;
        $this->weaponlikeInOffhand = $weaponlikeInOffhand;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Weight of worn armor, weapon and shield is NOT counted, see PPH page 114 left column.
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
     * @param HelmCode $helmCode
     */
    public function setHelmCode(HelmCode $helmCode)
    {
        $this->helmCode = $helmCode;
    }

    /**
     * @return WeaponlikeCode
     */
    public function getWeaponlikeInMainHand()
    {
        return $this->weaponlikeInMainHand;
    }

    /**
     * @param WeaponlikeCode $weaponlikeInMainHand
     */
    public function setWeaponlikeInMainHand(WeaponlikeCode $weaponlikeInMainHand)
    {
        $this->weaponlikeInMainHand = $weaponlikeInMainHand;
    }

    /**
     * @return WeaponlikeCode
     */
    public function getWeaponlikeInOffhand()
    {
        return $this->weaponlikeInOffhand;
    }

    /**
     * @param WeaponlikeCode $weaponlikeInOffhand
     */
    public function setWeaponlikeInOffhand(WeaponlikeCode $weaponlikeInOffhand)
    {
        $this->weaponlikeInOffhand = $weaponlikeInOffhand;
    }

}