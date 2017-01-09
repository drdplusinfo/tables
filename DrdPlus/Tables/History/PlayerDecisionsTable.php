<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Codes\PlayerDecisionCode;
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

    const DECISION = 'decision';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::DECISION];
    }

    /**
     * @param PlayerDecisionCode $playerDecisionCode
     * @return int
     */
    public function getPointsToPrimaryProperties(PlayerDecisionCode $playerDecisionCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($playerDecisionCode, self::POINTS_TO_PRIMARY_PROPERTIES);
    }

    /**
     * @param PlayerDecisionCode $playerDecisionCode
     * @return int
     */
    public function getPointsToSecondaryProperties(PlayerDecisionCode $playerDecisionCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($playerDecisionCode, self::POINTS_TO_SECONDARY_PROPERTIES);
    }

    /**
     * @param PlayerDecisionCode $playerDecisionCode
     * @return int
     */
    public function getMaximumToSingleProperty(PlayerDecisionCode $playerDecisionCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($playerDecisionCode, self::MAXIMUM_TO_SINGLE_PROPERTY);
    }
}