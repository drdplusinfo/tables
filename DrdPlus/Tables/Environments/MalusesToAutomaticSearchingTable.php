<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Codes\ActivityIntensityCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;

/**
 * See PPH page 135 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_postihu_k_automatickemu_hledani
 */
class MalusesToAutomaticSearchingTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/maluses_to_automatic_searching.csv';
    }

    const MALUS = 'malus';

    /**
     * @return string[]|array
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::MALUS => self::NEGATIVE_INTEGER];
    }

    const AT_THE_SAME_TIME_WITH = 'at_the_same_time_with';

    /**
     * @return array
     */
    protected function getRowsHeader()
    {
        return [self::AT_THE_SAME_TIME_WITH];
    }

    /**
     * @param ActivityIntensityCode $activityIntensityCode
     * @return int
     * @throws \DrdPlus\Tables\Environments\Exceptions\CanNotSearchWithCurrentActivity
     */
    public function getMalusWhenSearchingAtTheSameTimeWith(ActivityIntensityCode $activityIntensityCode)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue($activityIntensityCode, self::MALUS);
        } catch (RequiredRowNotFound $requiredRowNotFound) {
            throw new Exceptions\CanNotSearchWithCurrentActivity(
                "Can not search when doing '$activityIntensityCode'"
            );
        }
    }
}