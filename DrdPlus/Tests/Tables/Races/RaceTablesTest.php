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

        $this->assertInstanceOf(RacesTable::class, $factory->getRacesTable());
        $this->assertInstanceOf(FemaleModifiersTable::class, $factory->getFemaleModifiersTable());
        $this->assertInstanceOf(SizeAndWeightTable::class, $factory->getSizeAndWeightTable());
    }
}
