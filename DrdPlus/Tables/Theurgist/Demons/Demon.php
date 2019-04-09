<?php
declare(strict_types=1);

namespace DrdPlus\Tables\Theurgist\Demons;

use DrdPlus\BaseProperties\Will;
use DrdPlus\Codes\Theurgist\DemonBodyCode;
use DrdPlus\Codes\Theurgist\DemonCode;
use DrdPlus\Codes\Theurgist\DemonKindCode;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonCapacity;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonEndurance;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Difficulty;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Duration;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Evocation;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Realm;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\RealmsAffection;
use Granam\Strict\Object\StrictObject;

class Demon extends StrictObject
{
    /**
     * @var DemonCode
     */
    private $demonCode;
    /**
     * @var Realm
     */
    private $realm;
    /**
     * @var Evocation
     */
    private $evocation;
    /**
     * @var DemonBodyCode
     */
    private $demonBodyCode;
    /**
     * @var DemonKindCode
     */
    private $demonKindCode;
    /**
     * @var RealmsAffection
     */
    private $realmsAffection;
    /**
     * @var Will
     */
    private $will;
    /**
     * @var Difficulty
     */
    private $difficulty;
    /**
     * @var Duration
     */
    private $duration;
    /**
     * @var DemonCapacity
     */
    private $demonCapacity;
    /**
     * @var DemonEndurance
     */
    private $demonEndurance;
    /**
     * @var DemonTraits
     */
    private $demonTraits;

    // speed,quality,duration,radius,strength,agility,knack,armor,area,invisibility
    public function __construct(
        DemonCode $demonCode,
        Realm $realm,
        Evocation $evocation,
        DemonBodyCode $demonBodyCode,
        DemonKindCode $demonKindCode,
        RealmsAffection $realmsAffection,
        Duration $duration,
        Difficulty $difficulty,
        DemonTraits $demonTraits,
        DemonCapacity $demonCapacity,
        DemonEndurance $demonEndurance,
        Will $will,
        DemonSpeed $demonSpeed,
        DemonQuality $demonQuality,
        DemonDuration $demonDuration,
        DemonRadius $demonRadius,
        DemonStrength $demonStrength,
        DemonAgility $demonAgility,
        DemonKnack $demonKnack,
        DemonArmor $demonArmor,
        Area $area,
        DemonInvisibility $demonInvisibility
    )
    {
        $this->demonCode = $demonCode;
        $this->realm = $realm;
        $this->evocation = $evocation;
        $this->demonBodyCode = $demonBodyCode;
        $this->demonKindCode = $demonKindCode;
        $this->realmsAffection = $realmsAffection;
        $this->will = $will;
        $this->duration = $duration;
        $this->difficulty = $difficulty;
        $this->demonCapacity = $demonCapacity;
        $this->demonEndurance = $demonEndurance;
        $this->demonTraits = $demonTraits;
    }

    public function getDemonCode(): DemonCode
    {
        return $this->demonCode;
    }

    public function getRealm(): Realm
    {
        return $this->realm;
    }

    public function getEvocation(): Evocation
    {
        return $this->evocation;
    }

    public function getDemonBodyCode(): DemonBodyCode
    {
        return $this->demonBodyCode;
    }

    public function getDemonKindCode(): DemonKindCode
    {
        return $this->demonKindCode;
    }

    public function getRealmsAffection(): RealmsAffection
    {
        return $this->realmsAffection;
    }

    public function getWill(): Will
    {
        return $this->will;
    }

    public function getDifficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }

    public function getDemonCapacity(): DemonCapacity
    {
        return $this->demonCapacity;
    }

    public function getDemonEndurance(): DemonEndurance
    {
        return $this->demonEndurance;
    }

    public function getDemonTraits(): DemonTraits
    {
        return $this->demonTraits;
    }
}