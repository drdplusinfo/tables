<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Codes\PlayerDecisionCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;

class BackgroundPointsTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/background_points.csv';
    }

    const BACKGROUND_POINTS = 'background_points';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::BACKGROUND_POINTS => self::POSITIVE_INTEGER,
        ];
    }

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [
            PlayerDecisionsTable::PLAYER_DECISION,
        ];
    }

    /**
     * @param PlayerDecisionCode $playerDecisionCode
     * @return int
     * @throws \DrdPlus\Tables\History\Exceptions\UnknownFate
     */
    public function getBackgroundPointsByFate(PlayerDecisionCode $playerDecisionCode)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue($playerDecisionCode, self::BACKGROUND_POINTS);
        } catch (RequiredRowNotFound $requiredRowNotFound) {
            throw new Exceptions\UnknownFate('Unknown fate ' . $playerDecisionCode->getValue());
        }
    }

}