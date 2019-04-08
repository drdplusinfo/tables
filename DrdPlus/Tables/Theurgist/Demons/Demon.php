<?php
declare(strict_types=1);

namespace DrdPlus\Tables\Theurgist\Demons;

use DrdPlus\BaseProperties\Will;
use DrdPlus\Codes\Theurgist\DemonBodyCode;
use DrdPlus\Codes\Theurgist\DemonCode;
use DrdPlus\Codes\Theurgist\DemonKindCode;
use DrdPlus\Tables\Measurements\Time\TimeBonus;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonCapacity;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonEndurance;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Duration;
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
     * @var TimeBonus
     */
    private $summoningTimeBonus;
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
     * @var DemonDifficulty
     */
    private $demonDifficulty;
    /**
     * @var DemonCapacity
     */
    private $demonCapacity;
    /**
     * @var DemonEndurance
     */
    private $demonEndurance;
    /**
     * @var DemonTrait
     */
    private $demonTrait;

    public function __construct(
        DemonCode $demonCode,
        Realm $realm,
        TimeBonus $summoningTimeBonus,
        DemonBodyCode $demonBodyCode,
        DemonKindCode $demonKindCode,
        RealmsAffection $realmsAffection,
        Will $will,
        Duration $duration,
        DemonDifficulty $demonDifficulty,
        DemonCapacity $demonCapacity,
        DemonEndurance $demonEndurance,
        DemonTrait $demonTrait
    )
    {
        $this->demonCode = $demonCode;
        $this->realm = $realm;
        $this->summoningTimeBonus = $summoningTimeBonus;
        $this->demonBodyCode = $demonBodyCode;
        $this->demonKindCode = $demonKindCode;
        $this->realmsAffection = $realmsAffection;
        $this->will = $will;
        $this->demonDifficulty = $demonDifficulty;
        $this->demonCapacity = $demonCapacity;
        $this->demonEndurance = $demonEndurance;
        $this->demonTrait = $demonTrait;
    }

    public function getRealm(): Realm
    {
        return $this->realm;
    }

    public function getSummoningTimeBonus(): TimeBonus
    {
        return $this->summoningTimeBonus;
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

    public function getDemonDifficulty(): DemonDifficulty
    {
        return $this->demonDifficulty;
    }

    public function getDemonCapacity(): DemonCapacity
    {
        return $this->demonCapacity;
    }

    public function getDemonEndurance(): DemonEndurance
    {
        return $this->demonEndurance;
    }

    public function getDemonTrait(): DemonTrait
    {
        return $this->demonTrait;
    }
}