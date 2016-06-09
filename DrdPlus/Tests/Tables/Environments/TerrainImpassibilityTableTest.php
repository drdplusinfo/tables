<?php
namespace DrdPlus\Tests\Tables\Environments;

use DrdPlus\Tables\Environments\TerrainImpassibilityTable;
use DrdPlus\Tests\Tables\TableTest;

class TerrainImpassibilityTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [['terrain', 'impassibility_of_terrain_from', 'impassibility_of_terrain_to']],
            (new TerrainImpassibilityTable())->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        self::assertSame(
            [
                'road' => ['impassibility_of_terrain_from' => 0, 'impassibility_of_terrain_to' => -2],
                'meadow' => ['impassibility_of_terrain_from' => -1, 'impassibility_of_terrain_to' => -4],
                'forest' => ['impassibility_of_terrain_from' => -1, 'impassibility_of_terrain_to' => -8],
                'jungle' => ['impassibility_of_terrain_from' => -6, 'impassibility_of_terrain_to' => -12],
                'swamp' => ['impassibility_of_terrain_from' => -10, 'impassibility_of_terrain_to' => -18],
                'mountains' => ['impassibility_of_terrain_from' => -10, 'impassibility_of_terrain_to' => -20],
                'desert' => ['impassibility_of_terrain_from' => -5, 'impassibility_of_terrain_to' => -20],
                'icy_plains' => ['impassibility_of_terrain_from' => -5, 'impassibility_of_terrain_to' => -20],
            ],
            (new TerrainImpassibilityTable())->getIndexedValues()
        );
    }

}
