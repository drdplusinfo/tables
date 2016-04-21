<?php
namespace DrdPlus\Tables\Healing;

class HealingBonusForActivityTable extends AbstractHealingBonusForTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/healing_bonus_for_activity.csv';
    }

    protected function getExpectedDataHeader()
    {
        return ['bonus' => self::INTEGER];
    }

    /**
     * @param string $activityCode
     * @return int
     * @throws \DrdPlus\Tables\Healing\Exceptions\UnknownInfluenceOnHealingCode
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getHealingBonusForActivity($activityCode)
    {
        return $this->getHealingBonusBy($activityCode);
    }

}