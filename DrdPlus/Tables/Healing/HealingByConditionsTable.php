<?php
namespace DrdPlus\Tables\Healing;

class HealingByConditionsTable extends AbstractHealingByTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/healing_by_conditions.csv';
    }

    protected function getExpectedDataHeader()
    {
        return ['bonus' => self::SLASH_ARRAY_OF_INTEGERS];
    }

    /**
     * @param string $conditionsCode
     * @return int
     * @throws \DrdPlus\Tables\Healing\Exceptions\UnknownInfluenceOnHealingCode
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getHealingBonusByConditions($conditionsCode)
    {
        return $this->getHealingBonusBy($conditionsCode);
    }
}