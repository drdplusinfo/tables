<?php
namespace DrdPlus\Tables;

use DrdPlus\Tables\Measurements\Amount\AmountTable;
use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tables\Races\FemaleModifiersTable;
use DrdPlus\Tables\Races\RacesTable;
use Granam\Strict\Object\StrictObject;

class Tables extends StrictObject
{
    private $tables = [];

    /**
     * @return AmountTable
     */
    public function getAmountTable()
    {
        if (!isset($this->tables[AmountTable::class])) {
            $this->tables[AmountTable::class] = new AmountTable();
        }

        return $this->tables[AmountTable::class];
    }

    /**
     * @return BaseOfWoundsTable
     */
    public function getBaseOfWoundsTable()
    {
        if (!isset($this->tables[BaseOfWoundsTable::class])) {
            $this->tables[BaseOfWoundsTable::class] = new BaseOfWoundsTable();
        }

        return $this->tables[BaseOfWoundsTable::class];
    }

    /**
     * @return DistanceTable
     */
    public function getDistanceTable()
    {
        if (!isset($this->tables[DistanceTable::class])) {
            $this->tables[DistanceTable::class] = new DistanceTable();
        }

        return $this->tables[DistanceTable::class];
    }

    /**
     * @return ExperiencesTable
     */
    public function getExperiencesTable()
    {
        if (!isset($this->tables[ExperiencesTable::class])) {
            $this->tables[ExperiencesTable::class] = new ExperiencesTable($this->getWoundsTable());
        }

        return $this->tables[ExperiencesTable::class];
    }

    /**
     * @return FatigueTable
     */
    public function getFatigueTable()
    {
        if (!isset($this->tables[FatigueTable::class])) {
            $this->tables[FatigueTable::class] = new FatigueTable($this->getWoundsTable());
        }

        return $this->tables[FatigueTable::class];
    }

    /**
     * @return SpeedTable
     */
    public function getSpeedTable()
    {
        if (!isset($this->tables[SpeedTable::class])) {
            $this->tables[SpeedTable::class] = new SpeedTable();
        }

        return $this->tables[SpeedTable::class];
    }

    /**
     * @return TimeTable
     */
    public function getTimeTable()
    {
        if (!isset($this->tables[TimeTable::class])) {
            $this->tables[TimeTable::class] = new TimeTable();
        }

        return $this->tables[TimeTable::class];
    }

    /**
     * @return WeightTable
     */
    public function getWeightTable()
    {
        if (!isset($this->tables[WeightTable::class])) {
            $this->tables[WeightTable::class] = new WeightTable();
        }

        return $this->tables[WeightTable::class];
    }

    /**
     * @return WoundsTable
     */
    public function getWoundsTable()
    {
        if (!isset($this->tables[WoundsTable::class])) {
            $this->tables[WoundsTable::class] = new WoundsTable();
        }

        return $this->tables[WoundsTable::class];
    }

    /**
     * @return FemaleModifiersTable
     */
    public function getFemaleModifiersTable()
    {
        if (!isset($this->tables[FemaleModifiersTable::class])) {
            $this->tables[FemaleModifiersTable::class] = new FemaleModifiersTable();
        }

        return $this->tables[FemaleModifiersTable::class];
    }

    /**
     * @return RacesTable
     */
    public function getRacesTable()
    {
        if (!isset($this->tables[RacesTable::class])) {
            $this->tables[RacesTable::class] = new RacesTable();
        }

        return $this->tables[RacesTable::class];
    }
}