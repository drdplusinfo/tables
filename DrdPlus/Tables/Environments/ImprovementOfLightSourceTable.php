<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Codes\Environment\LightSourceEnvironmentCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

class ImprovementOfLightSourceTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/improvement_of_light_source.csv';
    }

    const IMPROVEMENT_OF_LIGHT_SOURCE = 'improvement_of_light_source';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::IMPROVEMENT_OF_LIGHT_SOURCE => self::POSITIVE_INTEGER];
    }

    const ENVIRONMENT = 'environment';

    protected function getRowsHeader()
    {
        return [self::ENVIRONMENT];
    }

    /**
     * @param LightSourceEnvironmentCode $lightSourceEnvironmentCode
     * @return int
     */
    public function getLightSourceImprovement(LightSourceEnvironmentCode $lightSourceEnvironmentCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($lightSourceEnvironmentCode, self::IMPROVEMENT_OF_LIGHT_SOURCE);
    }

}