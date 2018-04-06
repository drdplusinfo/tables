<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Distance;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use Granam\String\StringInterface;

class DistanceBonus extends AbstractBonus
{

    /** @var DistanceTable */
    private $distanceTable;

    /**
     * @param int $value
     * @param DistanceTable $distanceTable
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    public function __construct($value, DistanceTable $distanceTable)
    {
        parent::__construct($value);
        $this->distanceTable = $distanceTable;
    }

    /**
     * @param string|StringInterface $wantedUnit = null
     * @return Distance
     */
    public function getDistance($wantedUnit = null): Distance
    {
        $distance = $this->distanceTable->toDistance($this);
        if ($wantedUnit === null) {
            return $distance;
        }

        return $distance->getInUnit($wantedUnit);
    }

}