<?php
namespace DrdPlus\Tests\Tables\Measurements;

use DrdPlus\Tables\Measurements\Amount\AmountTable;
use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\MeasurementTables;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;

class MeasurementTablesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_get_any_table()
    {
        $factory = new MeasurementTables();

        $this->assertInstanceOf(AmountTable::class, $factory->getAmountTable());
        $this->assertInstanceOf(BaseOfWoundsTable::class, $factory->getBaseOfWoundsTable());
        $this->assertInstanceOf(DistanceTable::class, $factory->getDistanceTable());
        $this->assertInstanceOf(DistanceTable::class, $factory->getDistanceTable());
        $this->assertInstanceOf(ExperiencesTable::class, $factory->getExperiencesTable());
        $this->assertInstanceOf(FatigueTable::class, $factory->geFatigueTable());
        $this->assertInstanceOf(SpeedTable::class, $factory->getSpeedTable());
        $this->assertInstanceOf(TimeTable::class, $factory->getTimeTable());
        $this->assertInstanceOf(WeightTable::class, $factory->getWeightTable());
        $this->assertInstanceOf(WoundsTable::class, $factory->getWoundsTable());
    }
}
