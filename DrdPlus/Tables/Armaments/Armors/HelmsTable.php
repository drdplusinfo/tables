<?php
namespace DrdPlus\Tables\Armaments\Armors;

class HelmsTable extends AbstractArmorsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/helms.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['helm'];
    }

}