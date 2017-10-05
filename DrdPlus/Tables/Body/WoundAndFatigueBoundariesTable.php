<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Body;

use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Derived\Endurance;
use DrdPlus\Properties\Derived\FatigueBoundary;
use DrdPlus\Properties\Derived\Toughness;
use DrdPlus\Properties\Derived\WoundBoundary;
use DrdPlus\Tables\Partials\AbstractTable;
use DrdPlus\Tables\Tables;

/**
 * See PPH page 41 right column, @link https://pph.drdplus.info/#tabulka_meze_zraneni_a_unavy
 */
class WoundAndFatigueBoundariesTable extends AbstractTable
{
    const BOUNDARY = 'boundary';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::BOUNDARY];
    }

    const PROPERTY = 'property';

    /**
     * @return array|string[]
     */
    protected function getColumnsHeader(): array
    {
        return [self::PROPERTY];
    }

    /**
     * @return array
     */
    public function getIndexedValues(): array
    {
        return [
            PropertyCode::WOUND_BOUNDARY => [self::PROPERTY => PropertyCode::TOUGHNESS],
            PropertyCode::FATIGUE_BOUNDARY => [self::PROPERTY => PropertyCode::ENDURANCE],
        ];
    }

    /**
     * @param Toughness $toughness
     * @param Tables $tables
     * @return WoundBoundary
     */
    public function getWoundBoundary(Toughness $toughness, Tables $tables): WoundBoundary
    {
        return WoundBoundary::getIt($toughness, $tables);
    }

    /**
     * @param Endurance $endurance
     * @param Tables $tables
     * @return FatigueBoundary
     */
    public function getFatigueBoundary(Endurance $endurance, Tables $tables): FatigueBoundary
    {
        return FatigueBoundary::getIt($endurance, $tables);
    }

}