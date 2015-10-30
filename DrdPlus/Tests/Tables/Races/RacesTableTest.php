<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Properties\Derived\Endurance;
use DrdPlus\Properties\Derived\Senses;
use DrdPlus\Properties\Native\Infravision;
use DrdPlus\Properties\Native\NativeRegeneration;
use DrdPlus\Tests\Races\TestWithMockery;

class RacesTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_get_common_dwarf_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonDwarfModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(1),
                RacesTable::AGILITY => Agility::getIt(-1),
                RacesTable::KNACK => Knack::getIt(0),
                RacesTable::WILL => Will::getIt(2),
                RacesTable::INTELLIGENCE => Intelligence::getIt(-1),
                RacesTable::CHARISMA => Charisma::getIt(-2),
                RacesTable::ENDURANCE => Endurance::getIt(1),
                RacesTable::INFRAVISION => Infravision::getIt(true),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(-1),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_wood_dwarf_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getWoodDwarfModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(1),
                RacesTable::AGILITY => Agility::getIt(-1),
                RacesTable::KNACK => Knack::getIt(0),
                RacesTable::WILL => Will::getIt(1),
                RacesTable::INTELLIGENCE => Intelligence::getIt(-1),
                RacesTable::CHARISMA => Charisma::getIt(-1),
                RacesTable::ENDURANCE => Endurance::getIt(1),
                RacesTable::INFRAVISION => Infravision::getIt(true),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(-1),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_mountain_dwarf_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getMountainDwarfModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(2),
                RacesTable::AGILITY => Agility::getIt(-1),
                RacesTable::KNACK => Knack::getIt(0),
                RacesTable::WILL => Will::getIt(2),
                RacesTable::INTELLIGENCE => Intelligence::getIt(-2),
                RacesTable::CHARISMA => Charisma::getIt(-2),
                RacesTable::ENDURANCE => Endurance::getIt(1),
                RacesTable::INFRAVISION => Infravision::getIt(true),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(-1),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_common_elf_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonElfModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(-1),
                RacesTable::AGILITY => Agility::getIt(1),
                RacesTable::KNACK => Knack::getIt(1),
                RacesTable::WILL => Will::getIt(-2),
                RacesTable::INTELLIGENCE => Intelligence::getIt(1),
                RacesTable::CHARISMA => Charisma::getIt(1),
                RacesTable::ENDURANCE => Endurance::getIt(-1),
                RacesTable::INFRAVISION => Infravision::getIt(false),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(0),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_dark_elf_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getDarkElfModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(0),
                RacesTable::AGILITY => Agility::getIt(0),
                RacesTable::KNACK => Knack::getIt(0),
                RacesTable::WILL => Will::getIt(0),
                RacesTable::INTELLIGENCE => Intelligence::getIt(1),
                RacesTable::CHARISMA => Charisma::getIt(0),
                RacesTable::ENDURANCE => Endurance::getIt(-1),
                RacesTable::INFRAVISION => Infravision::getIt(true),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(0),
                RacesTable::REQUIRES_DM_AGREEMENT => 1
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_green_elf_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getGreenElfModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(-1),
                RacesTable::AGILITY => Agility::getIt(1),
                RacesTable::KNACK => Knack::getIt(0),
                RacesTable::WILL => Will::getIt(-1),
                RacesTable::INTELLIGENCE => Intelligence::getIt(1),
                RacesTable::CHARISMA => Charisma::getIt(1),
                RacesTable::ENDURANCE => Endurance::getIt(-1),
                RacesTable::INFRAVISION => Infravision::getIt(false),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(0),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_common_human_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonHumanModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(0),
                RacesTable::AGILITY => Agility::getIt(0),
                RacesTable::KNACK => Knack::getIt(0),
                RacesTable::WILL => Will::getIt(0),
                RacesTable::INTELLIGENCE => Intelligence::getIt(0),
                RacesTable::CHARISMA => Charisma::getIt(0),
                RacesTable::ENDURANCE => Endurance::getIt(0),
                RacesTable::INFRAVISION => Infravision::getIt(false),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(0),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_highlander_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getHighlanderModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(1),
                RacesTable::AGILITY => Agility::getIt(0),
                RacesTable::KNACK => Knack::getIt(0),
                RacesTable::WILL => Will::getIt(1),
                RacesTable::INTELLIGENCE => Intelligence::getIt(-1),
                RacesTable::CHARISMA => Charisma::getIt(-1),
                RacesTable::ENDURANCE => Endurance::getIt(0),
                RacesTable::INFRAVISION => Infravision::getIt(false),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(0),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_common_hobbit_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonHobbitModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(-3),
                RacesTable::AGILITY => Agility::getIt(1),
                RacesTable::KNACK => Knack::getIt(1),
                RacesTable::WILL => Will::getIt(0),
                RacesTable::INTELLIGENCE => Intelligence::getIt(-1),
                RacesTable::CHARISMA => Charisma::getIt(2),
                RacesTable::ENDURANCE => Endurance::getIt(0),
                RacesTable::INFRAVISION => Infravision::getIt(false),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(0),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_common_kroll_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonKrollModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(3),
                RacesTable::AGILITY => Agility::getIt(-2),
                RacesTable::KNACK => Knack::getIt(-1),
                RacesTable::WILL => Will::getIt(1),
                RacesTable::INTELLIGENCE => Intelligence::getIt(-3),
                RacesTable::CHARISMA => Charisma::getIt(-1),
                RacesTable::ENDURANCE => Endurance::getIt(0),
                RacesTable::INFRAVISION => Infravision::getIt(false),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(true),
                RacesTable::SENSES => Senses::getIt(0),
                RacesTable::REQUIRES_DM_AGREEMENT => ''
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_wild_kroll_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getWildKrollModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(3),
                RacesTable::AGILITY => Agility::getIt(-1),
                RacesTable::KNACK => Knack::getIt(-2),
                RacesTable::WILL => Will::getIt(2),
                RacesTable::INTELLIGENCE => Intelligence::getIt(-3),
                RacesTable::CHARISMA => Charisma::getIt(-2),
                RacesTable::ENDURANCE => Endurance::getIt(0),
                RacesTable::INFRAVISION => Infravision::getIt(false),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(true),
                RacesTable::SENSES => Senses::getIt(0),
                RacesTable::REQUIRES_DM_AGREEMENT => 1
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_common_orc_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonOrcModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(0),
                RacesTable::AGILITY => Agility::getIt(2),
                RacesTable::KNACK => Knack::getIt(0),
                RacesTable::WILL => Will::getIt(-1),
                RacesTable::INTELLIGENCE => Intelligence::getIt(0),
                RacesTable::CHARISMA => Charisma::getIt(-2),
                RacesTable::ENDURANCE => Endurance::getIt(0),
                RacesTable::INFRAVISION => Infravision::getIt(true),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(1),
                RacesTable::REQUIRES_DM_AGREEMENT => 1
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_goblin_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getGoblinModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(-1),
                RacesTable::AGILITY => Agility::getIt(2),
                RacesTable::KNACK => Knack::getIt(1),
                RacesTable::WILL => Will::getIt(-2),
                RacesTable::INTELLIGENCE => Intelligence::getIt(0),
                RacesTable::CHARISMA => Charisma::getIt(-1),
                RacesTable::ENDURANCE => Endurance::getIt(0),
                RacesTable::INFRAVISION => Infravision::getIt(true),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(1),
                RacesTable::REQUIRES_DM_AGREEMENT => 1
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_skurut_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getSkurutModifiers();
        $this->assertEquals(
            [
                RacesTable::STRENGTH => Strength::getIt(1),
                RacesTable::AGILITY => Agility::getIt(1),
                RacesTable::KNACK => Knack::getIt(-1),
                RacesTable::WILL => Will::getIt(0),
                RacesTable::INTELLIGENCE => Intelligence::getIt(0),
                RacesTable::CHARISMA => Charisma::getIt(-2),
                RacesTable::ENDURANCE => Endurance::getIt(0),
                RacesTable::INFRAVISION => Infravision::getIt(true),
                RacesTable::NATIVE_REGENERATION => NativeRegeneration::getIt(false),
                RacesTable::SENSES => Senses::getIt(1),
                RacesTable::REQUIRES_DM_AGREEMENT => 1
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_got_expected_values()
    {
        $racesTable = new RacesTable();
        $this->assertSame(
            [
                0 => [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => '', 7 => '', 8 => '', 9 => '', 10 => ''],
                1 => [0 => 1, 1 => 0, 2 => 0, 3 => 1, 4 => -1, 5 => -1, 6 => '', 7 => '', 8 => '', 9 => '', 10 => ''],
                2 => [0 => -1, 1 => 1, 2 => 1, 3 => -2, 4 => 1, 5 => 1, 6 => -1, 7 => '', 8 => '', 9 => '', 10 => ''],
                3 => [0 => -1, 1 => 1, 2 => 0, 3 => -1, 4 => 1, 5 => 1, 6 => -1, 7 => '', 8 => '', 9 => '', 10 => ''],
                4 => [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 1, 5 => 0, 6 => -1, 7 => 1, 8 => '', 9 => '', 10 => 1],
                5 => [0 => 1, 1 => -1, 2 => 0, 3 => 2, 4 => -1, 5 => -2, 6 => 1, 7 => 1, 8 => '', 9 => -1, 10 => ''],
                6 => [0 => 1, 1 => -1, 2 => 0, 3 => 1, 4 => -1, 5 => -1, 6 => 1, 7 => 1, 8 => '', 9 => -1, 10 => ''],
                7 => [0 => 2, 1 => -1, 2 => 0, 3 => 2, 4 => -2, 5 => -2, 6 => 1, 7 => 1, 8 => '', 9 => -1, 10 => ''],
                8 => [0 => -3, 1 => 1, 2 => 1, 3 => 0, 4 => -1, 5 => 2, 6 => '', 7 => '', 8 => '', 9 => '', 10 => ''],
                9 => [0 => 3, 1 => -2, 2 => -1, 3 => 1, 4 => -3, 5 => -1, 6 => '', 7 => '', 8 => 1, 9 => '', 10 => ''],
                10 => [0 => 3, 1 => -1, 2 => -2, 3 => 2, 4 => -3, 5 => -2, 6 => '', 7 => '', 8 => 1, 9 => '', 10 => 1],
                11 => [0 => 0, 1 => 2, 2 => 0, 3 => -1, 4 => 0, 5 => -2, 6 => '', 7 => 1, 8 => '', 9 => 1, 10 => 1],
                12 => [0 => 1, 1 => 1, 2 => -1, 3 => 0, 4 => 0, 5 => -2, 6 => '', 7 => 1, 8 => '', 9 => 1, 10 => 1],
                13 => [0 => -1, 1 => 2, 2 => 1, 3 => -2, 4 => 0, 5 => -1, 6 => '', 7 => 1, 8 => '', 9 => 1, 10 => 1],
            ],
            $racesTable->getValues()
        );
    }
}
