<?php
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
    public function getWoundBoundary(Toughness $toughness, Tables $tables)
    {
        return WoundBoundary::getIt($toughness, $tables);
    }

    /**
     * @param Endurance $endurance
     * @param Tables $tables
     * @return FatigueBoundary
     */
    public function getFatigueBoundary(Endurance $endurance, Tables $tables)
    {
        return FatigueBoundary::getIt($endurance, $tables);
    }

}