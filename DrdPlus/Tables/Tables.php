<?php
namespace DrdPlus\Tables;

use DrdPlus\Tables\Amount\AmountTable;
use DrdPlus\Tables\Distance\DistanceTable;
use DrdPlus\Tables\Experiences\ExperiencesTable;
use DrdPlus\Tables\Fatigue\FatigueTable;
use DrdPlus\Tables\Speed\SpeedTable;
use DrdPlus\Tables\Time\TimeTable;
use DrdPlus\Tables\Weight\WeightTable;
use DrdPlus\Tables\Wounds\WoundsTable;
use Granam\Strict\Object\StrictObject;

class Tables extends StrictObject
{

    /**
     * @var AmountTable
     */
    private $amountTable;

    /**
     * @var DistanceTable
     */
    private $distanceTable;

    /**
     * @var FatigueTable
     */
    private $fatigueTable;

    /**
     * @var SpeedTable
     */
    private $speedTable;

    /**
     * @var TimeTable
     */
    private $timeTable;

    /**
     * @var WeightTable
     */
    private $weightTable;

    /**
     * @var WoundsTable
     */
    private $woundsTable;

    /**
     * @var ExperiencesTable
     */
    private $experiencesTable;

    public function __construct()
    {
        $this->amountTable = new AmountTable();
        $this->distanceTable = new DistanceTable();
        $this->fatigueTable = new FatigueTable();
        $this->speedTable = new SpeedTable();
        $this->timeTable = new TimeTable();
        $this->weightTable = new WeightTable();
        $this->woundsTable = new WoundsTable();
        $this->experiencesTable = new ExperiencesTable($this->woundsTable);
    }

    /**
     * @return AmountTable
     */
    public function getAmountTable()
    {
        return $this->amountTable;
    }

    /**
     * @return DistanceTable
     */
    public function getDistanceTable()
    {
        return $this->distanceTable;
    }

    /**
     * @return FatigueTable
     */
    public function getFatigueTable()
    {
        return $this->fatigueTable;
    }

    /**
     * @return SpeedTable
     */
    public function getSpeedTable()
    {
        return $this->speedTable;
    }

    /**
     * @return TimeTable
     */
    public function getTimeTable()
    {
        return $this->timeTable;
    }

    /**
     * @return WeightTable
     */
    public function getWeightTable()
    {
        return $this->weightTable;
    }

    /**
     * @return WoundsTable
     */
    public function getWoundsTable()
    {
        return $this->woundsTable;
    }

    /**
     * @return ExperiencesTable
     */
    public function getExperiencesTable()
    {
        return $this->experiencesTable;
    }

}
