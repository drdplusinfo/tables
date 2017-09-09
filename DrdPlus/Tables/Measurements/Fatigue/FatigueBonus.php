<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Fatigue;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

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
