<?php
namespace DrdPlus\Tables;

use DrdPlus\Tables\Armaments\Armourer;

class TablesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_get_any_table()
    {
        $tables = new Tables();
        foreach ($this->getExpectedTableClasses() as $expectedTableClass) {
            $baseName = preg_replace('~(?:.+[\\\])?(\w+)$~', '$1', $expectedTableClass);
            $getTable = "get{$baseName}";
            self::assertTrue(
                method_exists($tables, $getTable),
                'Tables factory is missing getter for ' . $baseName . ' (or the class should be abstract?)'
            );
            $table = $tables->$getTable();
            self::assertInstanceOf($expectedTableClass, $table);
            $getterReflection = new \ReflectionMethod($tables, $getTable);
            self::assertContains("@return $baseName", $getterReflection->getDocComment());
        }
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
