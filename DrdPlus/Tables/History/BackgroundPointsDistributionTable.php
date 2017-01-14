<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Codes\History\AncestryCode;
use DrdPlus\Codes\History\BackgroundCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;

class BackgroundPointsDistributionTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/background_points_distribution.csv';
    }

    const MAX_POINTS = 'max_points';
    const MORE_THAN_FOR_ANCESTRY_UP_TO = 'more_than_for_ancestry_up_to';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::MAX_POINTS => self::POSITIVE_INTEGER,
            self::MORE_THAN_FOR_ANCESTRY_UP_TO => self::POSITIVE_INTEGER,
        ];
    }

    const BACKGROUND = 'background';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::BACKGROUND];
    }

    /**
     * @param BackgroundCode $backgroundCode
     * @param AncestryTable $ancestryTable
     * @param AncestryCode $ancestryCode
     * @return int
     * @throws \DrdPlus\Tables\History\Exceptions\UnknownBackgroundCode
     */
    public function getMaxPointsToDistribute(
        BackgroundCode $backgroundCode,
        AncestryTable $ancestryTable,
        AncestryCode $ancestryCode
    )
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $row = $this->getRow($backgroundCode);
        } catch (RequiredRowNotFound $requiredRowNotFound) {
            throw new Exceptions\UnknownBackgroundCode("Given background {$backgroundCode} is not known");
        }
        $maxPointsToDistribute = $row[self::MAX_POINTS];
        $moreThanAncestryUpTo = $row[self::MORE_THAN_FOR_ANCESTRY_UP_TO];
        if ($moreThanAncestryUpTo === false) {
            return $maxPointsToDistribute;
        }
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $backgroundPointsForAncestry = $ancestryTable->getBackgroundPointsByAncestry($ancestryCode);
        if ($backgroundPointsForAncestry + $moreThanAncestryUpTo >= $maxPointsToDistribute) {
            return $maxPointsToDistribute;
        }

        return $backgroundPointsForAncestry + $moreThanAncestryUpTo;
    }

}