<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tables\Parts\AbstractFileTable;

class ArmorsTable extends AbstractFileTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/armors.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['armor'];
    }

    protected function getExpectedDataHeader()
    {
        return [
            'required strength' => self::INTEGER,
            'restriction' => self::INTEGER,
            'protection' => self::INTEGER,
            'weigh' => self::INTEGER,
        ];
    }

}