<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Integer\PositiveInteger;

class PossessionTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/possession.csv';
    }

    const GOLD_COINS = 'gold_coins';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::GOLD_COINS => self::POSITIVE_INTEGER,
        ];
    }

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [BackgroundPointsTable::BACKGROUND_POINTS];
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return int
     * @throws \DrdPlus\Tables\History\Exceptions\UnexpectedBackgroundPoints
     */
    public function getPossessionAsGoldCoins(PositiveInteger $backgroundPoints)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue($backgroundPoints, self::GOLD_COINS);
        } catch (RequiredRowNotFound $requiredRowNotFound) {
            throw new Exceptions\UnexpectedBackgroundPoints(
                "Given background points {$backgroundPoints} are not supported"
            );
        }
    }

}