<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\Base\Amount\AmountTable;
use DrdPlus\Tables\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tables\Base\Distance\DistanceTable;
use DrdPlus\Tables\Experiences\ExperiencesTable;
use DrdPlus\Tables\Fatigue\FatigueTable;
use DrdPlus\Tables\Price\PriceTable;
use DrdPlus\Tables\Base\Speed\SpeedTable;
use DrdPlus\Tables\Tables;
use DrdPlus\Tables\Base\Time\TimeTable;
use DrdPlus\Tables\Base\Weight\WeightTable;
use DrdPlus\Tables\Base\Wounds\WoundsTable;

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
