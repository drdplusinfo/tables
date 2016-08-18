<?php
namespace DrdPlus\Tables\Armaments\Weapons;

use DrdPlus\Tables\Armaments\Partials\AbstractMissingArmamentSkillsTable;
use Granam\Integer\Tools\ToInteger;

class MissingWeaponSkillsTable extends AbstractMissingArmamentSkillsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/missing_weapon_skills.csv';
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
     */
    public function getMalusesForWeaponSkill($skillRank)
    {
        return $this->getRow([ToInteger::toPositiveInteger($skillRank)]);
    }

    /**
     * @param int $skillRank
     * @return int
     */
    public function getFightNumberForWeaponSkill($skillRank)
    {
        return $this->getValueForSkillRank($skillRank, self::FIGHT_NUMBER);
    }

    /**
     * @param int $skillRank
     * @return int
     */
    public function getAttackNumberForWeaponSkill($skillRank)
    {
        return $this->getValueForSkillRank($skillRank, self::ATTACK_NUMBER);
    }

    /**
     * @param int $skillRank
     * @return int
     */
    public function getCoverForWeaponSkill($skillRank)
    {
        return $this->getValueForSkillRank($skillRank, self::COVER);
    }

    /**
     * @param int $skillRank
     * @return int
     */
    public function getBaseOfWoundsForWeaponSkill($skillRank)
    {
        return $this->getValueForSkillRank($skillRank, self::BASE_OF_WOUNDS);
    }

}