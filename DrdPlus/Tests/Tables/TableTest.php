<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\Table;

class TableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function All_tables_have_table_interface()
    {
        $this->assertTrue(method_exists(Table::class, 'getIndexedValues'));
        $this->assertTrue(method_exists(Table::class, 'getValues'));
        $this->assertTrue(method_exists(Table::class, 'getHeader'));
        foreach (self::getTableClasses() as $tableClass) {
            $this->assertTrue(
                is_a($tableClass, Table::class, true),
                "Table $tableClass does not implements " . Table::class . 'interface'
            );
        }
    }

    public static function getTableClasses()
    {
        $tablesReflection = new \ReflectionClass(Table::class);
        $rootDir = dirname($tablesReflection->getFileName());
        $rootNamespace = $tablesReflection->getNamespaceName();

        return self::scanForTables($rootDir, $rootNamespace);
    }

    private static function scanForTables($rootDir, $rootNamespace)
    {
        $tableClasses = [];
        foreach (scandir($rootDir) as $fileOrDir) {
            $fullPath = $rootDir . DIRECTORY_SEPARATOR . $fileOrDir;
            if ($fileOrDir !== '.' && $fileOrDir !== '..') {
                if (is_dir($fullPath)) {
                    $tableClasses = array_merge($tableClasses, self::scanForTables($fullPath, $rootNamespace . '\\' . $fileOrDir));
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
