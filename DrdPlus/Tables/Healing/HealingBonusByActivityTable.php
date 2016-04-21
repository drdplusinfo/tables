<?php
namespace DrdPlus\Tables\Healing;

use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

class HealingBonusByActivityTable extends AbstractFileTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/healing_bonus_by_activity.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['situation'];
    }

    protected function getExpectedDataHeader()
    {
        return ['bonus' => self::INTEGER];
    }

    /**
     * @param string $activityName
     * @return int
     * @throws \DrdPlus\Tables\Healing\Exceptions\UnknownActivityOnHealing
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getHealingBonusForActivity($activityName)
    {
        try {
            return $this->getValue([$activityName], 'bonus');
        } catch (RequiredRowDataNotFound $exception) {
            throw new Exceptions\UnknownActivityOnHealing(
                'Unknown activity ' . ValueDescriber::describe($activityName)
            );
        }
    }

}