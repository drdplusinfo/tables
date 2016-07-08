<?php
namespace DrdPlus\Tables\Body\Healing;

class HealingByActivityTable extends AbstractHealingByTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/healing_by_activity.csv';
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return ['bonus' => self::INTEGER];
    }

    /**
     * @param string $activityCode
     * @return int
     * @throws \DrdPlus\Tables\Body\Healing\Exceptions\UnknownCodeOfHealingInfluence
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getHealingBonusByActivity($activityCode)
    {
        return $this->getHealingBonusBy($activityCode);
    }

}