<?php
namespace DrdPlus\Tables\Measurements\Time;

use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Integer\Tools\ToInteger;
use Granam\Tools\ValueDescriber;

/**
 * Applicable only for time bonus for days, months and years, see PPH page 65, left column.
 */
class BonusAdjustmentByTimeTable extends AbstractFileTable
{
    /**
     * @var TimeTable
     */
    private $timeTable;

    public function __construct(TimeTable $timeTable)
    {
        $this->timeTable = $timeTable;
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/bonus_adjustment_by_time.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['hours_of_activity_per_day'];
    }

    const ADJUSTMENT_HEADER = 'adjustment';

    protected function getExpectedDataHeader()
    {
        return [
            self::ADJUSTMENT_HEADER => self::INTEGER
        ];
    }

    /**
     * @param Time $originalActivityTime
     * @param int $hoursPerDay
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\NotApplicableOnShorterThanDay
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\UnexpectedHoursPerDayForTimeBonusAdjustment
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function adjustBy(Time $originalActivityTime, $hoursPerDay)
    {
        $inDays = $originalActivityTime->findDays();
        if (($inDays === null && $originalActivityTime->findMonths() === null && $originalActivityTime->findYears() === null)
            || ($inDays !== null && $inDays->getValue() < 1)
        ) {
            throw new Exceptions\NotApplicableOnShorterThanDay(
                'Only at least one day of activity can be adjusted by change of hours of such activity, got '
                . $originalActivityTime->getValue() . ' ' . $originalActivityTime->getUnit() . '(s)'
            );
        }
        $bonusAdjustment = $this->getBonusAdjustmentForHoursPerDay($hoursPerDay);
        $finalBonusValue = $originalActivityTime->getBonus()->getValue() + $bonusAdjustment;

        $finalBonus = new TimeBonus($finalBonusValue, $this->timeTable);

        $finalTime = $finalBonus->findTime($originalActivityTime->getUnit());
        if ($finalTime !== null) {
            return $finalTime;
        }

        return $finalBonus->getTime();
    }

    /**
     * @param int $hoursPerDay
     * @return int
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\UnexpectedHoursPerDayForTimeBonusAdjustment
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getBonusAdjustmentForHoursPerDay($hoursPerDay)
    {
        try {
            return $this->getValue([ToInteger::toInteger($hoursPerDay)], self::ADJUSTMENT_HEADER);
        } catch (RequiredRowDataNotFound $requiredRowDataNotFound) {
            throw new Exceptions\UnexpectedHoursPerDayForTimeBonusAdjustment(
                'Expected 1 to 24 hours of activity per day, got ' . ValueDescriber::describe($hoursPerDay)
                . ' From what universe you came from?'
            );
        }
    }

}