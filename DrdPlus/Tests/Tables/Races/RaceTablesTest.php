<?php
namespace DrdPlus\Tests\Tables\Races;

use DrdPlus\Tables\Races\FemaleModifiersTable;
use DrdPlus\Tables\Races\RacesTable;
use DrdPlus\Tables\Races\RaceTables;
use DrdPlus\Tables\Races\SizeAndWeightTable;

class RaceTablesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_tables()
    {
        $factory = new RaceTables();

        $this->assertInstanceOf(RacesTable::class, $raceTables = $factory->getRacesTable());
        $this->assertSame($raceTables, $factory->getRacesTable());

        $this->assertInstanceOf(FemaleModifiersTable::class, $femaleModifiers = $factory->getFemaleModifiersTable());
        $this->assertSame($femaleModifiers, $factory->getFemaleModifiersTable());

        $this->assertInstanceOf(SizeAndWeightTable::class, $sizeAndWeightTable = $factory->getSizeAndWeightTable());
        $this->assertSame($sizeAndWeightTable, $factory->getSizeAndWeightTable());
    }
}
