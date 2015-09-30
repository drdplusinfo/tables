<?php
namespace DrdPlus\Tables\Distance;

use DrdPlus\Tables\Parts\AbstractBonus;

class DistanceBonus extends AbstractBonus
{

    /**
     * @var DistanceTable
     */
    private $distanceTable;

    /**
     * @param int $value
     * @param DistanceTable $distanceTable
     */
    public function __construct($value, DistanceTable $distanceTable)
    {
        parent::__construct($value);
        $this->distanceTable = $distanceTable;
    }

    /**
     * @return Distance
     */
    public function getDistance()
    {
        return $this->distanceTable->toDistance($this);
    }

}
