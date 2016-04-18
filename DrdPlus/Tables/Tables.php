<?php
namespace DrdPlus\Tables;

use DrdPlus\Tables\Armaments\Armors\ArmorsTable;
use DrdPlus\Tables\Measurements\Amount\AmountTable;
use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tables\Professions\BackgroundSkillsTable;
use DrdPlus\Tables\Races\FemaleModifiersTable;
use DrdPlus\Tables\Races\RacesTable;
use Granam\Strict\Object\StrictObject;

class Tables extends StrictObject implements \IteratorAggregate
{
    private $tables = [];

    /**
     * @return AmountTable
     */
    public function getAmountTable()
    {
        if (!array_key_exists(AmountTable::class, $this->tables)) {
            $this->tables[AmountTable::class] = new AmountTable();
        }

        return $this->tables[AmountTable::class];
    }

    /**
     * @return BaseOfWoundsTable
     */
    public function getBaseOfWoundsTable()
    {
        if (!array_key_exists(BaseOfWoundsTable::class, $this->tables)) {
            $this->tables[BaseOfWoundsTable::class] = new BaseOfWoundsTable();
        }

        return $this->tables[BaseOfWoundsTable::class];
    }

    /**
     * @return DistanceTable
     */
    public function getDistanceTable()
    {
        if (!array_key_exists(DistanceTable::class, $this->tables)) {
            $this->tables[DistanceTable::class] = new DistanceTable();
        }

        return $this->tables[DistanceTable::class];
    }

    /**
     * @return ExperiencesTable
     */
    public function getExperiencesTable()
    {
        if (!array_key_exists(ExperiencesTable::class, $this->tables)) {
            $this->tables[ExperiencesTable::class] = new ExperiencesTable($this->getWoundsTable());
        }

        return $this->tables[ExperiencesTable::class];
    }

    /**
     * @return FatigueTable
     */
    public function getFatigueTable()
    {
        if (!array_key_exists(FatigueTable::class, $this->tables)) {
            $this->tables[FatigueTable::class] = new FatigueTable($this->getWoundsTable());
        }

        return $this->tables[FatigueTable::class];
    }

    /**
     * @return SpeedTable
     */
    public function getSpeedTable()
    {
        if (!array_key_exists(SpeedTable::class, $this->tables)) {
            $this->tables[SpeedTable::class] = new SpeedTable();
        }

        return $this->tables[SpeedTable::class];
    }

    /**
     * @return TimeTable
     */
    public function getTimeTable()
    {
        if (!array_key_exists(TimeTable::class, $this->tables)) {
            $this->tables[TimeTable::class] = new TimeTable();
        }

        return $this->tables[TimeTable::class];
    }

    /**
     * @return WeightTable
     */
    public function getWeightTable()
    {
        if (!array_key_exists(WeightTable::class, $this->tables)) {
            $this->tables[WeightTable::class] = new WeightTable();
        }

        return $this->tables[WeightTable::class];
    }

    /**
     * @return WoundsTable
     */
    public function getWoundsTable()
    {
        if (!array_key_exists(WoundsTable::class, $this->tables)) {
            $this->tables[WoundsTable::class] = new WoundsTable();
        }

        return $this->tables[WoundsTable::class];
    }

    /**
     * @return FemaleModifiersTable
     */
    public function getFemaleModifiersTable()
    {
        if (!array_key_exists(FemaleModifiersTable::class, $this->tables)) {
            $this->tables[FemaleModifiersTable::class] = new FemaleModifiersTable();
        }

        return $this->tables[FemaleModifiersTable::class];
    }

    /**
     * @return RacesTable
     */
    public function getRacesTable()
    {
        if (!array_key_exists(RacesTable::class, $this->tables)) {
            $this->tables[RacesTable::class] = new RacesTable();
        }

        return $this->tables[RacesTable::class];
    }

    /**
     * @return BackgroundSkillsTable
     */
    public function getBackgroundSkillsTable()
    {
        if (!array_key_exists(BackgroundSkillsTable::class, $this->tables)) {
            $this->tables[BackgroundSkillsTable::class] = new BackgroundSkillsTable();
        }

        return $this->tables[BackgroundSkillsTable::class];
    }

    /**
     * @return ArmorsTable
     */
    public function getArmorsTable()
    {
        if (!array_key_exists(ArmorsTable::class, $this->tables)) {
            $this->tables[ArmorsTable::class] = new ArmorsTable();
        }

        return $this->tables[ArmorsTable::class];
    }

    public function getIterator()
    {
        return new \ArrayObject([
            $this->getAmountTable(),
            $this->getBackgroundSkillsTable(),
            $this->getBaseOfWoundsTable(),
            $this->getDistanceTable(),
            $this->getExperiencesTable(),
            $this->getFatigueTable(),
            $this->getFemaleModifiersTable(),
            $this->getRacesTable(),
            $this->getSpeedTable(),
            $this->getTimeTable(),
            $this->getWeightTable(),
            $this->getWoundsTable(),
            $this->getArmorsTable(),
        ]);
    }

}
