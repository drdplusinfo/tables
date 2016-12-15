<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Codes\Environment\LightConditionsCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

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
     * @return array
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::QUALITY => self::INTEGER];
    }

    const LIGHT_CONDITIONS = 'light_conditions';

    /**
     * @return array
     */
    protected function getRowsHeader()
    {
        return [self::LIGHT_CONDITIONS];
    }

    /**
     * @param LightConditionsCode $lightConditionsCode
     * @return int
     */
    public function getLightingQuality(LightConditionsCode $lightConditionsCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($lightConditionsCode, self::QUALITY);
    }
}