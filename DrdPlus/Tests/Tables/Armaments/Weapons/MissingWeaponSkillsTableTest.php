<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons;

use DrdPlus\Tables\Armaments\Weapons\MissingWeaponSkillsTable;
use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

class MissingWeaponSkillsTableTest extends TestWithMockery implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [['skill_rank', 'fight_number', 'attack_number', 'cover', 'base_of_wounds']],
            (new MissingWeaponSkillsTable())->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        self::assertSame(
            [
                '0' => [
                    'skill_rank' => 0,
                    'fight_number' => -3,
                    'attack_number' => -3,
                    'cover' => -2,
                    'base_of_wounds' => -1,
                ],
                '1' => [
                    'skill_rank' => 1,
                    'fight_number' => -2,
                    'attack_number' => -2,
                    'cover' => -1,
                    'base_of_wounds' => -1,
                ],
                '2' => [
                    'skill_rank' => 2,
                    'fight_number' => -1,
                    'attack_number' => -1,
                    'cover' => -1,
                    'base_of_wounds' => 0,
                ],
                '3' => [
                    'skill_rank' => 3,
                    'fight_number' => 0,
                    'attack_number' => 0,
                    'cover' => 0,
                    'base_of_wounds' => 0,
                ]
            ],
            (new MissingWeaponSkillsTable())->getIndexedValues()
        );
    }

    /**
     * @test
     */
    public function I_can_get_maluses_for_missing_weapon_skill()
    {
        self::assertSame(
            [
                'skill_rank' => 2,
                'fight_number' => -1,
                'attack_number' => -1,
                'cover' => -1,
                'base_of_wounds' => 0
            ],
            (new MissingWeaponSkillsTable())->getMalusesForWeaponSkill(2)
        );
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_fight_number_for_missing_weapon_skill()
    {
        self::assertSame(
            -3,
            (new MissingWeaponSkillsTable())->getFightNumberForWeaponSkill(0)
        );
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_attack_number_for_missing_weapon_skill()
    {
        self::assertSame(
            -2,
            (new MissingWeaponSkillsTable())->getAttackNumberForWeaponSkill(1)
        );
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_cover_for_missing_weapon_skill()
    {
        self::assertSame(
            0,
            (new MissingWeaponSkillsTable())->getCoverForWeaponSkill(3)
        );
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_base_of_wounds_for_missing_weapon_skill()
    {
        self::assertSame(
            0,
            (new MissingWeaponSkillsTable())->getBaseOfWoundsForWeaponSkill(2)
        );
    }

}