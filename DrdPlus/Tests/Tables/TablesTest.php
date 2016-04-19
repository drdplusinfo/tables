<?php
namespace DrdPlus\Tables;

use DrdPlus\Tables\Armaments\Armourer;
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

        self::assertInstanceOf(AmountTable::class, $amountTable = $tables->getAmountTable());
        self::assertSame($amountTable, $tables->getAmountTable());

        self::assertInstanceOf(BaseOfWoundsTable::class, $baseOfWoundsTable = $tables->getBaseOfWoundsTable());
        self::assertSame($baseOfWoundsTable, $tables->getBaseOfWoundsTable());

        self::assertInstanceOf(DistanceTable::class, $distanceTable = $tables->getDistanceTable());
        self::assertSame($distanceTable, $tables->getDistanceTable());

        self::assertInstanceOf(ExperiencesTable::class, $experiencesTable = $tables->getExperiencesTable());
        self::assertSame($experiencesTable, $tables->getExperiencesTable());

        self::assertInstanceOf(FatigueTable::class, $fatigueTable = $tables->getFatigueTable());
        self::assertSame($fatigueTable, $tables->getFatigueTable());

        self::assertInstanceOf(SpeedTable::class, $speedTable = $tables->getSpeedTable());
        self::assertSame($speedTable, $tables->getSpeedTable());

        self::assertInstanceOf(TimeTable::class, $timeTable = $tables->getTimeTable());
        self::assertSame($timeTable, $tables->getTimeTable());

        self::assertInstanceOf(WeightTable::class, $weightTable = $tables->getWeightTable());
        self::assertSame($weightTable, $tables->getWeightTable());

        self::assertInstanceOf(WoundsTable::class, $woundsTable = $tables->getWoundsTable());
        self::assertSame($woundsTable, $tables->getWoundsTable());

        self::assertInstanceOf(RacesTable::class, $raceTables = $tables->getRacesTable());
        self::assertSame($raceTables, $tables->getRacesTable());

        self::assertInstanceOf(FemaleModifiersTable::class, $femaleModifiers = $tables->getFemaleModifiersTable());
        self::assertSame($femaleModifiers, $tables->getFemaleModifiersTable());

        self::assertInstanceOf(BackgroundSkillsTable::class, $backgroundSkills = $tables->getBackgroundSkillsTable());
        self::assertSame($backgroundSkills, $tables->getBackgroundSkillsTable());
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
        sort($expectedTableClasses);
        sort($fetchedTableClasses);
        
        self::assertSameSize(
            $expectedTableClasses,
            $fetchedTableClasses,
            'Tables factory should give ' . implode(',', array_diff($expectedTableClasses, $fetchedTableClasses))
            . ' on iterating'
        );
        self::assertEquals($expectedTableClasses, $fetchedTableClasses);
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
                    foreach ($this->scanForTables($fullPath, $rootNamespace . '\\' . $fileOrDir) as $foundTable) {
                        $tableClasses[] = $foundTable;
                    }
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

    /**
     * @test
     */
    public function I_can_get_armourer()
    {
        $tables = new Tables();
        self::assertInstanceOf(Armourer::class, $armourer = $tables->getArmourer());
        self::assertSame($armourer, $tables->getArmourer(), 'Expected the same instance of ' . Armourer::class);
    }
}
