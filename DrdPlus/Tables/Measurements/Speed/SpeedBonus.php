<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Speed;

use DrdPlus\Tables\Measurements\Distance\DistanceBonus;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

class SpeedBonus extends AbstractBonus
{

    /**
     * @var SpeedTable
     */
    private $speedTable;

    /**
     * @param int $bonusValue
     * @param SpeedTable $speedTable
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    public function __construct($bonusValue, SpeedTable $speedTable)
    {
        parent::__construct($bonusValue);
        $this->speedTable = $speedTable;
    }

    /**
     * @param string|null $wantedUnit
     * @return Speed
     */
    public function getSpeed($wantedUnit = null)
    {
        return $this->speedTable->toSpeed($this, $wantedUnit);
    }

    /**
     * @param DistanceTable $distanceTable
     * @return \DrdPlus\Tables\Measurements\Distance\Distance
     */
    public function getDistancePerRound(DistanceTable $distanceTable)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return (new DistanceBonus($this->getValue(), $distanceTable))->getDistance();
    }

}