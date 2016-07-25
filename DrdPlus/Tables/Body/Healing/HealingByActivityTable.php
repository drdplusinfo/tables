<?php
namespace DrdPlus\Tables\Body\Healing;

use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

class HealingByActivityTable extends AbstractFileTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/healing_by_activity.csv';
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return ['bonus' => self::INTEGER];
    }

    protected function getRowsHeader()
    {
        return ['situation'];
    }

    /**
     * @param string $activityCode
     * @return int
     * @throws \DrdPlus\Tables\Body\Healing\Exceptions\UnknownCodeOfHealingInfluence
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getHealingBonusByActivity($activityCode)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue([$activityCode], 'bonus');
        } catch (RequiredRowDataNotFound $requiredRowDataNotFound) {
            throw new Exceptions\UnknownCodeOfHealingInfluence(
                'Unknown influence on healing code ' . ValueDescriber::describe($activityCode)
            );
        }
    }
}