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
use DrdPlus\Tables\Professions\BackgroundSkillsTable;
use DrdPlus\Tables\Races\FemaleModifiersTable;
use DrdPlus\Tables\Races\RacesTable;

class TablesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_get_any_table()
    {
        $factory = new Tables();

        $this->assertInstanceOf(AmountTable::class, $amountTable = $factory->getAmountTable());
        $this->assertSame($amountTable, $factory->getAmountTable());

        $this->assertInstanceOf(BaseOfWoundsTable::class, $baseOfWoundsTable = $factory->getBaseOfWoundsTable());
        $this->assertSame($baseOfWoundsTable, $factory->getBaseOfWoundsTable());

        $this->assertInstanceOf(DistanceTable::class, $distanceTable = $factory->getDistanceTable());
        $this->assertSame($distanceTable, $factory->getDistanceTable());

        $this->assertInstanceOf(ExperiencesTable::class, $experiencesTable = $factory->getExperiencesTable());
        $this->assertSame($experiencesTable, $factory->getExperiencesTable());

        $this->assertInstanceOf(FatigueTable::class, $fatigueTable = $factory->getFatigueTable());
        $this->assertSame($fatigueTable, $factory->getFatigueTable());

        $this->assertInstanceOf(SpeedTable::class, $speedTable = $factory->getSpeedTable());
        $this->assertSame($speedTable, $factory->getSpeedTable());

        $this->assertInstanceOf(TimeTable::class, $timeTable = $factory->getTimeTable());
        $this->assertSame($timeTable, $factory->getTimeTable());

        $this->assertInstanceOf(WeightTable::class, $weightTable = $factory->getWeightTable());
        $this->assertSame($weightTable, $factory->getWeightTable());

        $this->assertInstanceOf(WoundsTable::class, $woundsTable = $factory->getWoundsTable());
        $this->assertSame($woundsTable, $factory->getWoundsTable());

        $this->assertInstanceOf(RacesTable::class, $raceTables = $factory->getRacesTable());
        $this->assertSame($raceTables, $factory->getRacesTable());

        $this->assertInstanceOf(FemaleModifiersTable::class, $femaleModifiers = $factory->getFemaleModifiersTable());
        $this->assertSame($femaleModifiers, $factory->getFemaleModifiersTable());

        $this->assertInstanceOf(BackgroundSkillsTable::class, $backgroundSkills = $factory->getBackgroundSkillsTable());
        $this->assertSame($backgroundSkills, $factory->getBackgroundSkillsTable());
    }
}
