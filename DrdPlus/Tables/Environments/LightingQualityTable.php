<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Codes\Environment\LightConditionsCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

/**
 * See PPH page 127 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_kvality_osvetleni
 */
class LightingQualityTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/lighting_quality.csv';
    }

    const QUALITY = 'quality';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::QUALITY => self::INTEGER];
    }

    const LIGHT_CONDITIONS = 'light_conditions';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::LIGHT_CONDITIONS];
    }

    /**
     * @param LightConditionsCode $lightConditionsCode
     * @return int
     */
    public function getLightingQualityOnConditions(LightConditionsCode $lightConditionsCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($lightConditionsCode, self::QUALITY);
    }
}