<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\MissingProtectiveArmamentSkill;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentSkillTable;
use Granam\Integer\PositiveInteger;

/**
 * See PPH page 148 left column, @link https://pph.drdplus.jaroslavtyc.com/#pouzivani_stitu
 */
class ShieldUsageSkillTable extends AbstractArmamentSkillTable implements MissingProtectiveArmamentSkill
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/missing_shield_skill.csv';
    }

    const COVER_MALUS = 'cover_malus';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::RESTRICTION_BONUS => self::POSITIVE_INTEGER,
            self::COVER_MALUS => self::NEGATIVE_INTEGER,
        ];
    }

    /**
     * @param int|PositiveInteger $skillRank
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

    /**
     * @param int|PositiveInteger $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getCoverMalusForSkillRank($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueForSkillRank($skillRank, self::COVER_MALUS);
    }

}