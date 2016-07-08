<?php
namespace DrdPlus\Tables\Body\Healing;

use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

abstract class AbstractHealingByTable extends AbstractFileTable
{
    protected function getExpectedRowsHeader()
    {
        return ['situation'];
    }

    /**
     * @param string $activityName
     * @return int
     * @throws \DrdPlus\Tables\Body\Healing\Exceptions\UnknownCodeOfHealingInfluence
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    protected function getHealingBonusBy($activityName)
    {
        try {
            return $this->getValue([$activityName], 'bonus');
        } catch (RequiredRowDataNotFound $requiredRowDataNotFound) {
            throw new Exceptions\UnknownCodeOfHealingInfluence(
                'Unknown influence on healing code ' . ValueDescriber::describe($activityName)
            );
        }
    }

}