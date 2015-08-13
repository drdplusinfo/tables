<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\BonusBased\Amount\AmountTable;
use DrdPlus\Tables\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tables\BonusBased\Distance\DistanceTable;
use DrdPlus\Tables\Derived\Experiences\ExperiencesTable;
use DrdPlus\Tables\Derived\Fatigue\FatigueTable;
use DrdPlus\Tables\Derived\Price\PriceTable;
use DrdPlus\Tables\BonusBased\Speed\SpeedTable;
use DrdPlus\Tables\Tables;
use DrdPlus\Tables\BonusBased\Time\TimeTable;
use DrdPlus\Tables\BonusBased\Weight\WeightTable;
use DrdPlus\Tables\BonusBased\Wounds\WoundsTable;

class TablesTest extends TestWithMockery
{

    /**
     * @test
     */
    public function can_give_any_of_table()
    {
        $tables = new Tables();
        $this->assertInstanceOf(AmountTable::class, $tables->getAmountTable());
        $this->assertInstanceOf(BaseOfWoundsTable::class, $tables->getBaseOfWoundsTable());
        $this->assertInstanceOf(DistanceTable::class, $tables->getDistanceTable());
        $this->assertInstanceOf(ExperiencesTable::class, $tables->getExperiencesTable());
        $this->assertInstanceOf(FatigueTable::class, $tables->getFatigueTable());
        $this->assertInstanceOf(PriceTable::class, $tables->getPriceTable());
        $this->assertInstanceOf(SpeedTable::class, $tables->getSpeedTable());
        $this->assertInstanceOf(TimeTable::class, $tables->getTimeTable());
        $this->assertInstanceOf(WeightTable::class, $tables->getWeightTable());
        $this->assertInstanceOf(WoundsTable::class, $tables->getWoundsTable());
    }

}
