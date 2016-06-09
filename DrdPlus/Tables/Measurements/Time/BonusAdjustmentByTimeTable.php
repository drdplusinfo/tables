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

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::ADJUSTMENT_HEADER => self::INTEGER
        ];
    }

    /**
     * Warning! Only activity with unlimited maximal time can get bonus by slowing down, other activities can get only malus by speeding up.
     * @param Time $originalActivityTime
     * @param int $hoursPerDay
     * @param bool $activityIsNotLimitedByTime = false
     * @return Time
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotProlongActivityPerDayWithLimitedTime
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\NotApplicableOnShorterThanDay
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\UnexpectedHoursPerDayForTimeBonusAdjustment
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function adjustBy(Time $originalActivityTime, $hoursPerDay, $activityIsNotLimitedByTime = false)
    {
        $inDays = $originalActivityTime->findDays();
        if (($inDays !== null && $inDays->getValue() < 1)
            || ($inDays === null && $originalActivityTime->findMonths() === null && $originalActivityTime->findYears() === null)
        ) {
            throw new Exceptions\NotApplicableOnShorterThanDay(
                'Only at least one day of activity can be adjusted by change of hours of such activity, got '
                . $originalActivityTime->getValue() . ' ' . $originalActivityTime->getUnit() . '(s)'
            );
        }
        if (!$activityIsNotLimitedByTime && $hoursPerDay > Time::HOURS_PER_DAY) {
            throw new Exceptions\CanNotProlongActivityPerDayWithLimitedTime(
                'Got request to prolong activity by ' . $hoursPerDay . ' hours per day with original activity time '
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