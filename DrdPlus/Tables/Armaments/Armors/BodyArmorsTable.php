<?php
namespace DrdPlus\Tables\Armaments\Armors;

class BodyArmorsTable extends AbstractArmorsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/body_armors.csv';
    }

    protected function getRowsHeader()
    {
        return ['body_armor'];
    }
}