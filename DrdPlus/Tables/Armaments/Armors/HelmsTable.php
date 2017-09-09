<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Armors;

/**
 * See PPH page 90 left column, @link https://pph.drdplus.info/#tabulka_zbroji_a_prileb
 */
class HelmsTable extends AbstractArmorsTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/helms.csv';
    }

    const HELM = 'helm';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::HELM];
    }

}