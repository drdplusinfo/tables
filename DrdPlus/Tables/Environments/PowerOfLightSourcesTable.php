<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Codes\Environment\LightSourceCode;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Partials\AbstractFileTable;

class PowerOfLightSourcesTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/power_of_light_sources.csv';
    }

    const POWER = 'power';

    /**
     * @return array
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::POWER => self::INTEGER];
    }

    const LIGHT_SOURCE = 'light_source';

    /**
     * @return array
     */
    protected function getRowsHeader()
    {
        return [self::LIGHT_SOURCE];
    }

    /**
     * @param LightSourceCode $lightSourceCode
     * @return int
     */
    public function getPowerOfLightSource(LightSourceCode $lightSourceCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($lightSourceCode, self::POWER);
    }

    /**
     * @param LightSourceCode $lightSourceCode
     * @param Distance $distance
     * @return int
     */
    public function calculateLightingQualityInDistance(LightSourceCode $lightSourceCode, Distance $distance)
    {
        return $this->getPowerOfLightSource($lightSourceCode) - 2*$distance->getBonus()->getValue();
    }

}