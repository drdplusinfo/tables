<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Partials\AbstractMissingArmamentSkillsTable;

class MissingArmorSkillsTable extends AbstractMissingArmamentSkillsTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/missing_armor_skills.csv';
    }

    const BONUS = 'bonus';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::BONUS => self::POSITIVE_INTEGER];
    }

    /**
     * @param $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function gotBonusForSkillRank($skillRank)
    {
        return $this->getValueForSkillRank($skillRank, self::BONUS);
    }

}