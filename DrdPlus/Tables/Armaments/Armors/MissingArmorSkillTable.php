<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\MissingProtectiveArmamentSkill;
use DrdPlus\Tables\Armaments\Partials\AbstractMissingArmamentSkillTable;

class MissingArmorSkillTable extends AbstractMissingArmamentSkillTable implements MissingProtectiveArmamentSkill
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/missing_armor_skill.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::RESTRICTION_BONUS => self::POSITIVE_INTEGER];
    }

    /**
     * @param $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRestrictionBonusForSkillRank($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueForSkillRank($skillRank, self::RESTRICTION_BONUS);
    }

}