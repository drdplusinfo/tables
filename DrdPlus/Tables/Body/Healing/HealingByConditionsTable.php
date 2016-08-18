<?php
namespace DrdPlus\Tables\Body\Healing;

use DrdPlus\Tables\Partials\AbstractFileTableWithPercents;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents;
use Granam\Tools\ValueDescriber;

class HealingByConditionsTable extends AbstractFileTableWithPercents
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/healing_by_conditions.csv';
    }

    protected function getRowsHeader()
    {
        return ['situation'];
    }

    /**
     * @param string $conditionsCode
     * @param HealingConditionsPercents $healingConditionsPercents
     * @return int
     * @throws \DrdPlus\Tables\Body\Healing\Exceptions\UnknownCodeOfHealingInfluence
     * @throws \DrdPlus\Tables\Body\Healing\Exceptions\UnexpectedHealingConditionsPercents
     */
    public function getHealingBonusByConditions($conditionsCode, HealingConditionsPercents $healingConditionsPercents)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getBonusBy($conditionsCode, $healingConditionsPercents);
        } catch (RequiredRowNotFound $requiredRowDataNotFound) {
            throw new Exceptions\UnknownCodeOfHealingInfluence(
                'Unknown influence on healing code ' . ValueDescriber::describe($conditionsCode)
            );
        } catch (UnexpectedPercents $unexpectedPercents) {
            throw new Exceptions\UnexpectedHealingConditionsPercents($unexpectedPercents->getMessage());
        }
    }

}