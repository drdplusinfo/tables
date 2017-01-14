<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Codes\History\AncestryCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Integer\PositiveInteger;

class AncestryTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/ancestry.csv';
    }

    const ANCESTRY = 'ancestry';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::ANCESTRY => self::STRING];
    }

    const POINTS = 'points';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::POINTS];
    }

    /**
     * @param PositiveInteger $backgroundPoints
     * @return AncestryCode
     * @throws \DrdPlus\Tables\History\Exceptions\UnexpectedBackgroundPointsForAncestry
     */
    public function getAncestryByPoints(PositiveInteger $backgroundPoints)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return AncestryCode::getIt($this->getValue($backgroundPoints, self::ANCESTRY));
        } catch (RequiredRowNotFound $requiredRowNotFound) {
            throw new Exceptions\UnexpectedBackgroundPointsForAncestry(
                "Given background points value {$backgroundPoints} is out of range"
            );
        }
    }

    /**
     * @param AncestryCode $ancestryCode
     * @return int
     * @throws \DrdPlus\Tables\History\Exceptions\UnknownAncestryCode
     */
    public function getPointsByAncestry(AncestryCode $ancestryCode)
    {
        foreach ($this->getIndexedValues() as $points => $wrappedAncestry) {
            $currentAncestry = end($wrappedAncestry);
            if ($currentAncestry === $ancestryCode->getValue()) {
                return $points;
            }
        }

        throw new Exceptions\UnknownAncestryCode("Given ancestry {$ancestryCode} is not known");
    }

}