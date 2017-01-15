<?php
namespace DrdPlus\Tables\Armaments\Armors;

/**
 * See PPH page 90 left column, https://pph.drdplus.jaroslavtyc.com/#tabulka_zbroji_a_prileb
 */
class HelmsTable extends AbstractArmorsTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/helms.csv';
    }

    const HELM = 'helm';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::HELM];
    }

}