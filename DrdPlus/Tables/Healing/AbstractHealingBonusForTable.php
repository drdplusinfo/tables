<?php
namespace DrdPlus\Tables\Healing;

use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

abstract class AbstractHealingBonusForTable extends AbstractFileTable
{
    protected function getExpectedRowsHeader()
    {
        return ['situation'];
    }

    /**
     * @param string $activityName
     * @return int
     * @throws \DrdPlus\Tables\Healing\Exceptions\UnknownInfluenceOnHealingCode
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    protected function getHealingBonusBy($activityName)
    {
        try {
            return $this->getValue([$activityName], 'bonus');
        } catch (RequiredRowDataNotFound $requiredRowDataNotFound) {
            throw new Exceptions\UnknownInfluenceOnHealingCode(
                'Unknown influence on healing code ' . ValueDescriber::describe($activityName)
            );
        }
    }

}