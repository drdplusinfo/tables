<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Codes\FateCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

class PlayerDecisionsTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/player_decisions.csv';
    }

    const POINTS_TO_PRIMARY_PROPERTIES = 'points_to_primary_properties';
    const POINTS_TO_SECONDARY_PROPERTIES = 'points_to_secondary_properties';
    const MAXIMUM_TO_SINGLE_PROPERTY = 'maximum_to_single_property';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::POINTS_TO_PRIMARY_PROPERTIES => self::POSITIVE_INTEGER,
            self::POINTS_TO_SECONDARY_PROPERTIES => self::POSITIVE_INTEGER,
            self::MAXIMUM_TO_SINGLE_PROPERTY => self::POSITIVE_INTEGER,
        ];
    }

    const FATE = 'fate';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::FATE];
    }

    /**
     * @param FateCode $fateCode
     * @return int
     */
    public function getPointsToPrimaryProperties(FateCode $fateCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($fateCode, self::POINTS_TO_PRIMARY_PROPERTIES);
    }

    /**
     * @param FateCode $fateCode
     * @return int
     */
    public function getPointsToSecondaryProperties(FateCode $fateCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($fateCode, self::POINTS_TO_SECONDARY_PROPERTIES);
    }

    /**
     * @param FateCode $fateCode
     * @return int
     */
    public function getMaximumToSingleProperty(FateCode $fateCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($fateCode, self::MAXIMUM_TO_SINGLE_PROPERTY);
    }
}