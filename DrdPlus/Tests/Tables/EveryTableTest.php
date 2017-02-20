<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\Table;
use PHPUnit\Framework\TestCase;

class EveryTableTest extends TestCase
{
    /**
     * @test
     */
    public function All_tables_have_table_interface()
    {
        self::assertTrue(method_exists(Table::class, 'getIndexedValues'));
        self::assertTrue(method_exists(Table::class, 'getValues'));
        self::assertTrue(method_exists(Table::class, 'getHeader'));
        foreach (self::getTableClasses() as $tableClass) {
            self::assertTrue(
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
                    foreach (self::scanForTables($fullPath, $rootNamespace . '\\' . $fileOrDir) as $tableClass) {
                        $tableClasses[] = $tableClass;
                    }
                } else if (is_file($fullPath) && preg_match('~(?<tableBasename>\w+Table)\.php$~', $fileOrDir, $matches)) {
                    $assembledTableClass = $rootNamespace . '\\' . $matches['tableBasename'];
                    self::assertTrue(
                        class_exists($assembledTableClass) || interface_exists($assembledTableClass),
                        "Class {$assembledTableClass} can not be auto-loaded"
                    );
                    $tableReflection = new \ReflectionClass($assembledTableClass);
                    $tableClasses[] = $tableReflection->getName();
                }
            }
        }

        return $tableClasses;
    }
}