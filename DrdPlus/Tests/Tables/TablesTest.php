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
        $tables = new Tables();

        $this->assertInstanceOf(AmountTable::class, $amountTable = $tables->getAmountTable());
        $this->assertSame($amountTable, $tables->getAmountTable());

        $this->assertInstanceOf(BaseOfWoundsTable::class, $baseOfWoundsTable = $tables->getBaseOfWoundsTable());
        $this->assertSame($baseOfWoundsTable, $tables->getBaseOfWoundsTable());

        $this->assertInstanceOf(DistanceTable::class, $distanceTable = $tables->getDistanceTable());
        $this->assertSame($distanceTable, $tables->getDistanceTable());

        $this->assertInstanceOf(ExperiencesTable::class, $experiencesTable = $tables->getExperiencesTable());
        $this->assertSame($experiencesTable, $tables->getExperiencesTable());

        $this->assertInstanceOf(FatigueTable::class, $fatigueTable = $tables->getFatigueTable());
        $this->assertSame($fatigueTable, $tables->getFatigueTable());

        $this->assertInstanceOf(SpeedTable::class, $speedTable = $tables->getSpeedTable());
        $this->assertSame($speedTable, $tables->getSpeedTable());

        $this->assertInstanceOf(TimeTable::class, $timeTable = $tables->getTimeTable());
        $this->assertSame($timeTable, $tables->getTimeTable());

        $this->assertInstanceOf(WeightTable::class, $weightTable = $tables->getWeightTable());
        $this->assertSame($weightTable, $tables->getWeightTable());

        $this->assertInstanceOf(WoundsTable::class, $woundsTable = $tables->getWoundsTable());
        $this->assertSame($woundsTable, $tables->getWoundsTable());

        $this->assertInstanceOf(RacesTable::class, $raceTables = $tables->getRacesTable());
        $this->assertSame($raceTables, $tables->getRacesTable());

        $this->assertInstanceOf(FemaleModifiersTable::class, $femaleModifiers = $tables->getFemaleModifiersTable());
        $this->assertSame($femaleModifiers, $tables->getFemaleModifiersTable());

        $this->assertInstanceOf(BackgroundSkillsTable::class, $backgroundSkills = $tables->getBackgroundSkillsTable());
        $this->assertSame($backgroundSkills, $tables->getBackgroundSkillsTable());
    }

    /**
     * @test
     */
    public function I_can_iterate_through_tables()
    {
        $tables = new Tables();
        $fetchedTableClasses = [];
        foreach ($tables as $table) {
            $fetchedTableClasses[] = get_class($table);
        }
        $expectedTableClasses = $this->getExpectedTableClasses();
        $this->assertSameSize($expectedTableClasses, $fetchedTableClasses);

        sort($expectedTableClasses);
        sort($fetchedTableClasses);
        $this->assertEquals($expectedTableClasses, $fetchedTableClasses);
    }

    private function getExpectedTableClasses()
    {
        $tablesReflection = new \ReflectionClass(Tables::class);
        $rootDir = dirname($tablesReflection->getFileName());
        $rootNamespace = $tablesReflection->getNamespaceName();

        return $this->scanForTables($rootDir, $rootNamespace);
    }

    private function scanForTables($rootDir, $rootNamespace)
    {
        $tableClasses = [];
        foreach (scandir($rootDir) as $fileOrDir) {
            $fullPath = $rootDir . DIRECTORY_SEPARATOR . $fileOrDir;
            if ($fileOrDir !== '.' && $fileOrDir !== '..') {
                if (is_dir($fullPath)) {
                    $tableClasses = array_merge($tableClasses, $this->scanForTables($fullPath, $rootNamespace . '\\' . $fileOrDir));
                } else if (is_file($fullPath)) {
                    if (preg_match('~(?<tableBasename>\w+Table)\.php$~', $fileOrDir, $matches)) {
                        $tableReflection = new \ReflectionClass($rootNamespace . '\\' . $matches['tableBasename']);
                        if (!$tableReflection->isAbstract()) {
                            $tableClasses[] = $tableReflection->getName();
                        }
                    }
                }
            }
        }

        return $tableClasses;
    }
}
