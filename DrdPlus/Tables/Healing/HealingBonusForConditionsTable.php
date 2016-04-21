<?php
namespace DrdPlus\Tables\Healing;

class HealingBonusForConditionsTable extends AbstractHealingBonusForTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/healing_bonus_for_conditions.csv';
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
    public function getHealingBonusForConditions($conditionsCode)
    {
        return $this->getHealingBonusBy($conditionsCode);
    }
}