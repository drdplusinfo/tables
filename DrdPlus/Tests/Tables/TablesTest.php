<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\Amount\AmountTable;
use DrdPlus\Tables\Distance\DistanceTable;
use DrdPlus\Tables\Experiences\ExperiencesTable;
use DrdPlus\Tables\Fatigue\FatigueTable;
use DrdPlus\Tables\Speed\SpeedTable;
use DrdPlus\Tables\Tables;
use DrdPlus\Tables\Time\TimeTable;
use DrdPlus\Tables\Weight\WeightTable;
use DrdPlus\Tables\Wounds\WoundsTable;

class TablesTest extends TestWithMockery
{

    /**
     * @test
     */
    public function can_give_any_on_table()
    {
        $tables = new Tables();
        $this->assertInstanceOf(AmountTable::class, $tables->getAmountTable());
        $this->assertInstanceOf(DistanceTable::class, $tables->getDistanceTable());
        $this->assertInstanceOf(ExperiencesTable::class, $tables->getExperiencesTable());
        $this->assertInstanceOf(FatigueTable::class, $tables->getFatigueTable());
        $this->assertInstanceOf(SpeedTable::class, $tables->getSpeedTable());
        $this->assertInstanceOf(TimeTable::class, $tables->getTimeTable());
        $this->assertInstanceOf(WeightTable::class, $tables->getWeightTable());
        $this->assertInstanceOf(WoundsTable::class, $tables->getWoundsTable());
    }

}
