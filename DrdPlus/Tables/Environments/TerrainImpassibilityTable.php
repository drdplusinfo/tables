<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Tables\Partials\AbstractFileTable;

class TerrainImpassibilityTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ .'/data/impassibility_of_terrain.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedRowsHeader()
    {
        return ['terrain'];
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            'impassibility_of_terrain_from' => self::INTEGER,
            'impassibility_of_terrain_to' => self::INTEGER,
        ];
    }

}