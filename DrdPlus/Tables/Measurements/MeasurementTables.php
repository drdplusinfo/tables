<?php
namespace DrdPlus\Tables\Measurements;

use DrdPlus\Tables\Measurements\Amount\AmountTable;
use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use Granam\Strict\Object\StrictObject;

class MeasurementTables extends StrictObject
{
    private $tables = [];

    /**
     * @return AmountTable
     */
    public function getAmountTable()
    {
        return $this->getTableFor('amount');
    }

    private function getTableFor($name, $parameter = null)
    {
        $name = ucfirst($name);
        $tableName = $name . 'Table';
        if (isset($this->tables[$tableName])) {
            return $this->tables[$tableName];
        }

        return $this->tables[$tableName] = $this->createTable($name, $tableName, $parameter);
    }

    private function createTable($name, $tableName, $parameter)
    {
        $tableClass = $this->determineTableClass($name, $tableName);

        return new $tableClass($parameter);
    }

    private function determineTableClass($name, $tableName)
    {
        $tableClass = __NAMESPACE__ . '\\' . $name . '\\' . $tableName;

        return $tableClass;
    }

    /**
     * @return BaseOfWoundsTable
     */
    public function getBaseOfWoundsTable()
    {
        return $this->getTableFor('baseOfWounds');
    }

    /**
     * @return DistanceTable
     */
    public function getDistanceTable()
    {
        return $this->getTableFor('distance');
    }

    /**
     * @return ExperiencesTable
     */
    public function getExperiencesTable()
    {
        return $this->getWoundsDependentTableFor('experiences');
    }

    private function getWoundsDependentTableFor($name)
    {
        $woundsTable = $this->getTableFor('wounds');

        return $this->getTableFor($name, $woundsTable);
    }

    /**
     * @return FatigueTable
     */
    public function getFatigueTable()
    {
        return $this->getWoundsDependentTableFor('fatigue');
    }

    /**
     * @return SpeedTable
     */
    public function getSpeedTable()
    {
        return $this->getTableFor('speed');
    }

    /**
     * @return TimeTable
     */
    public function getTimeTable()
    {
        return $this->getTableFor('time');
    }

    /**
     * @return WeightTable
     */
    public function getWeightTable()
    {
        return $this->getTableFor('weight');
    }

    /**
     * @return WoundsTable
     */
    public function getWoundsTable()
    {
        return $this->getTableFor('wounds');
    }
}
