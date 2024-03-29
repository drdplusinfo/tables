<?php declare(strict_types=1);

namespace DrdPlus\Tables\Theurgist\Demons;

use DrdPlus\Codes\Theurgist\DemonTraitCode;
use DrdPlus\Tables\Tables;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\RealmsAddition;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\RealmsAffection;
use Granam\Strict\Object\StrictObject;

class DemonTrait extends StrictObject
{
    private \DrdPlus\Codes\Theurgist\DemonTraitCode $demonTraitCode;
    private \DrdPlus\Tables\Tables $demonTraitsTable;

    /**
     * @param DemonTraitCode $demonTraitCode
     * @param Tables $tables
     */
    public function __construct(DemonTraitCode $demonTraitCode, Tables $tables)
    {
        $this->demonTraitCode = $demonTraitCode;
        $this->demonTraitsTable = $tables;
    }

    public function getRealmsAddition(): RealmsAddition
    {
        return $this->demonTraitsTable->getDemonTraitsTable()->getRealmsAddition($this->getDemonTraitCode());
    }

    public function getDemonTraitCode(): DemonTraitCode
    {
        return $this->demonTraitCode;
    }

    public function getRealmsAffection(): RealmsAffection
    {
        return $this->demonTraitsTable->getDemonTraitsTable()->getRealmsAffection($this->getDemonTraitCode());
    }

    public function __toString()
    {
        return $this->getDemonTraitCode()->getValue();
    }
}