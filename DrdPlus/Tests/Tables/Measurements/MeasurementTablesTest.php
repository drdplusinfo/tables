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

        $this->assertInstanceOf(AmountTable::class, $amountTable = $factory->getAmountTable());
        $this->assertSame($amountTable, $factory->getAmountTable());

        $this->assertInstanceOf(BaseOfWoundsTable::class, $baseOfWoundsTable = $factory->getBaseOfWoundsTable());
        $this->assertSame($baseOfWoundsTable, $factory->getBaseOfWoundsTable());

        $this->assertInstanceOf(DistanceTable::class, $distanceTable = $factory->getDistanceTable());
        $this->assertSame($distanceTable, $factory->getDistanceTable());

        $this->assertInstanceOf(ExperiencesTable::class, $experiencesTable = $factory->getExperiencesTable());
        $this->assertSame($experiencesTable, $factory->getExperiencesTable());

        $this->assertInstanceOf(FatigueTable::class, $fatigueTable = $factory->geFatigueTable());
        $this->assertSame($fatigueTable, $factory->geFatigueTable());

        $this->assertInstanceOf(SpeedTable::class, $speedTable =$factory->getSpeedTable());
        $this->assertSame($speedTable, $factory->getSpeedTable());

        $this->assertInstanceOf(TimeTable::class, $timeTable = $factory->getTimeTable());
        $this->assertSame($timeTable, $factory->getTimeTable());

        $this->assertInstanceOf(WeightTable::class, $weightTable = $factory->getWeightTable());
        $this->assertSame($weightTable, $factory->getWeightTable());

        $this->assertInstanceOf(WoundsTable::class, $woundsTable = $factory->getWoundsTable());
        $this->assertSame($woundsTable, $factory->getWoundsTable());
    }
}
