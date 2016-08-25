<?php
namespace DrdPlus\Tables\Armaments\Weapons;

use DrdPlus\Tables\Armaments\Partials\AbstractMissingArmamentSkillTable;
use Granam\Integer\Tools\ToInteger;

class MissingWeaponSkillTable extends AbstractMissingArmamentSkillTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/missing_weapon_skill.csv';
    }

    const FIGHT_NUMBER = 'fight_number';
    const ATTACK_NUMBER = 'attack_number';
    const COVER = 'cover';
    const BASE_OF_WOUNDS = 'base_of_wounds';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::SKILL_RANK => self::POSITIVE_INTEGER,
            self::FIGHT_NUMBER => self::NEGATIVE_INTEGER,
            self::ATTACK_NUMBER => self::NEGATIVE_INTEGER,
            self::COVER => self::NEGATIVE_INTEGER,
            self::BASE_OF_WOUNDS => self::NEGATIVE_INTEGER,
        ];
    }

    /**
     * @param int $skillRank
     * @return array
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getMalusesForWeaponSkill($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([ToInteger::toPositiveInteger($skillRank)]);
    }

    /**
     * @param int $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getFightNumberForWeaponSkill($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueForSkillRank($skillRank, self::FIGHT_NUMBER);
    }

    /**
     * @param int $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getAttackNumberForWeaponSkill($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueForSkillRank($skillRank, self::ATTACK_NUMBER);
    }

    /**
     * @param int $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getCoverForWeaponSkill($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueForSkillRank($skillRank, self::COVER);
    }

    /**
     * @param int $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getBaseOfWoundsForWeaponSkill($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueForSkillRank($skillRank, self::BASE_OF_WOUNDS);
    }

}