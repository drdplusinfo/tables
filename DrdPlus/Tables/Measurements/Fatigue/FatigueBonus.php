<?php
namespace DrdPlus\Tables\Measurements\Fatigue;

use DrdPlus\Tables\Measurements\Parts\AbstractBonus;

class FatigueBonus extends AbstractBonus
{

    /**
     * @var FatigueTable
     */
    private $fatigueTable;

    /**
     * @param int $value
     * @param FatigueTable $fatigueTable
     */
    public function __construct($value, FatigueTable $fatigueTable)
    {
        parent::__construct($value);
        $this->fatigueTable = $fatigueTable;
    }

    /**
     * @return Fatigue
     */
    public function getFatigue()
    {
        return $this->fatigueTable->toFatigue($this);
    }
}
