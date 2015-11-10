<?php
namespace DrdPlus\Tables\Races;

class RacesTableTest extends \PHPUnit_Framework_TestCase
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
                RacesTable::STRENGTH => 1,
                RacesTable::AGILITY => -1,
                RacesTable::KNACK => 0,
                RacesTable::WILL => 2,
                RacesTable::INTELLIGENCE => -1,
                RacesTable::CHARISMA => -2,
                RacesTable::ENDURANCE => 1,
                RacesTable::INFRAVISION => true,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => -1,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => 1,
                RacesTable::AGILITY => -1,
                RacesTable::KNACK => 0,
                RacesTable::WILL => 1,
                RacesTable::INTELLIGENCE => -1,
                RacesTable::CHARISMA => -1,
                RacesTable::ENDURANCE => 1,
                RacesTable::INFRAVISION => true,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => -1,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => 2,
                RacesTable::AGILITY => -1,
                RacesTable::KNACK => 0,
                RacesTable::WILL => 2,
                RacesTable::INTELLIGENCE => -2,
                RacesTable::CHARISMA => -2,
                RacesTable::ENDURANCE => 1,
                RacesTable::INFRAVISION => true,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => -1,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => -1,
                RacesTable::AGILITY => 1,
                RacesTable::KNACK => 1,
                RacesTable::WILL => -2,
                RacesTable::INTELLIGENCE => 1,
                RacesTable::CHARISMA => 1,
                RacesTable::ENDURANCE => -1,
                RacesTable::INFRAVISION => false,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 0,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => 0,
                RacesTable::AGILITY => 0,
                RacesTable::KNACK => 0,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => 1,
                RacesTable::CHARISMA => 0,
                RacesTable::ENDURANCE => -1,
                RacesTable::INFRAVISION => true,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 0,
                RacesTable::REQUIRES_DM_AGREEMENT => true
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
                RacesTable::STRENGTH => -1,
                RacesTable::AGILITY => 1,
                RacesTable::KNACK => 0,
                RacesTable::WILL => -1,
                RacesTable::INTELLIGENCE => 1,
                RacesTable::CHARISMA => 1,
                RacesTable::ENDURANCE => -1,
                RacesTable::INFRAVISION => false,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 0,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => 0,
                RacesTable::AGILITY => 0,
                RacesTable::KNACK => 0,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => 0,
                RacesTable::CHARISMA => 0,
                RacesTable::ENDURANCE => 0,
                RacesTable::INFRAVISION => false,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 0,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => 1,
                RacesTable::AGILITY => 0,
                RacesTable::KNACK => 0,
                RacesTable::WILL => 1,
                RacesTable::INTELLIGENCE => -1,
                RacesTable::CHARISMA => -1,
                RacesTable::ENDURANCE => 0,
                RacesTable::INFRAVISION => false,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 0,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => -3,
                RacesTable::AGILITY => 1,
                RacesTable::KNACK => 1,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => -1,
                RacesTable::CHARISMA => 2,
                RacesTable::ENDURANCE => 0,
                RacesTable::INFRAVISION => false,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 0,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => 3,
                RacesTable::AGILITY => -2,
                RacesTable::KNACK => -1,
                RacesTable::WILL => 1,
                RacesTable::INTELLIGENCE => -3,
                RacesTable::CHARISMA => -1,
                RacesTable::ENDURANCE => 0,
                RacesTable::INFRAVISION => false,
                RacesTable::NATIVE_REGENERATION => true,
                RacesTable::SENSES => 0,
                RacesTable::REQUIRES_DM_AGREEMENT => false
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
                RacesTable::STRENGTH => 3,
                RacesTable::AGILITY => -1,
                RacesTable::KNACK => -2,
                RacesTable::WILL => 2,
                RacesTable::INTELLIGENCE => -3,
                RacesTable::CHARISMA => -2,
                RacesTable::ENDURANCE => 0,
                RacesTable::INFRAVISION => false,
                RacesTable::NATIVE_REGENERATION => true,
                RacesTable::SENSES => 0,
                RacesTable::REQUIRES_DM_AGREEMENT => true
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
                RacesTable::STRENGTH => 0,
                RacesTable::AGILITY => 2,
                RacesTable::KNACK => 0,
                RacesTable::WILL => -1,
                RacesTable::INTELLIGENCE => 0,
                RacesTable::CHARISMA => -2,
                RacesTable::ENDURANCE => 0,
                RacesTable::INFRAVISION => true,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 1,
                RacesTable::REQUIRES_DM_AGREEMENT => true
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
                RacesTable::STRENGTH => -1,
                RacesTable::AGILITY => 2,
                RacesTable::KNACK => 1,
                RacesTable::WILL => -2,
                RacesTable::INTELLIGENCE => 0,
                RacesTable::CHARISMA => -1,
                RacesTable::ENDURANCE => 0,
                RacesTable::INFRAVISION => true,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 1,
                RacesTable::REQUIRES_DM_AGREEMENT => true
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
                RacesTable::STRENGTH => 1,
                RacesTable::AGILITY => 1,
                RacesTable::KNACK => -1,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => 0,
                RacesTable::CHARISMA => -2,
                RacesTable::ENDURANCE => 0,
                RacesTable::INFRAVISION => true,
                RacesTable::NATIVE_REGENERATION => false,
                RacesTable::SENSES => 1,
                RacesTable::REQUIRES_DM_AGREEMENT => true
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
                RacesTable::HUMAN => [
                    RacesTable::COMMON => [
                        RacesTable::STRENGTH => 0, RacesTable::AGILITY => 0, RacesTable::KNACK => 0, RacesTable::WILL => 0,
                        RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => 0, RacesTable::ENDURANCE => 0,
                        RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 0,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    RacesTable::HIGHLANDER => [RacesTable::STRENGTH => 1, RacesTable::AGILITY => 0, RacesTable::KNACK => 0,
                        RacesTable::WILL => 1, RacesTable::INTELLIGENCE => -1, RacesTable::CHARISMA => -1,
                        RacesTable::ENDURANCE => 0, RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => false,
                        RacesTable::SENSES => 0, RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RacesTable::ELF => [
                    RacesTable::COMMON => [
                        RacesTable::STRENGTH => -1, RacesTable::AGILITY => 1, RacesTable::KNACK => 1,
                        RacesTable::WILL => -2, RacesTable::INTELLIGENCE => 1, RacesTable::CHARISMA => 1,
                        RacesTable::ENDURANCE => -1, RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => false,
                        RacesTable::SENSES => 0, RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    RacesTable::GREEN => [
                        RacesTable::STRENGTH => -1, RacesTable::AGILITY => 1, RacesTable::KNACK => 0,
                        RacesTable::WILL => -1, RacesTable::INTELLIGENCE => 1, RacesTable::CHARISMA => 1,
                        RacesTable::ENDURANCE => -1, RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION =>
                            false, RacesTable::SENSES => 0, RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    RacesTable::DARK => [
                        RacesTable::STRENGTH => 0, RacesTable::AGILITY => 0, RacesTable::KNACK => 0,
                        RacesTable::WILL => 0, RacesTable::INTELLIGENCE => 1, RacesTable::CHARISMA => 0,
                        RacesTable::ENDURANCE => -1, RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false,
                        RacesTable::SENSES => 0, RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                RacesTable::DWARF => [
                    RacesTable::COMMON => [
                        RacesTable::STRENGTH => 1, RacesTable::AGILITY => -1, RacesTable::KNACK => 0, RacesTable::WILL => 2,
                        RacesTable::INTELLIGENCE => -1, RacesTable::CHARISMA => -2, RacesTable::ENDURANCE => 1,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => -1,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    RacesTable::WOOD => [
                        RacesTable::STRENGTH => 1, RacesTable::AGILITY => -1, RacesTable::KNACK => 0, RacesTable::WILL => 1,
                        RacesTable::INTELLIGENCE => -1, RacesTable::CHARISMA => -1, RacesTable::ENDURANCE => 1,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => -1,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    RacesTable::MOUNTAIN => [
                        RacesTable::STRENGTH => 2, RacesTable::AGILITY => -1, RacesTable::KNACK => 0, RacesTable::WILL => 2,
                        RacesTable::INTELLIGENCE => -2, RacesTable::CHARISMA => -2, RacesTable::ENDURANCE => 1,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => -1,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RacesTable::HOBBIT => [
                    RacesTable::COMMON => [
                        RacesTable::STRENGTH => -3, RacesTable::AGILITY => 1, RacesTable::KNACK => 1, RacesTable::WILL => 0,
                        RacesTable::INTELLIGENCE => -1, RacesTable::CHARISMA => 2, RacesTable::ENDURANCE => 0,
                        RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 0,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RacesTable::KROLL => [
                    RacesTable::COMMON => [
                        RacesTable::STRENGTH => 3, RacesTable::AGILITY => -2, RacesTable::KNACK => -1, RacesTable::WILL => 1,
                        RacesTable::INTELLIGENCE => -3, RacesTable::CHARISMA => -1, RacesTable::ENDURANCE => 0,
                        RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => true, RacesTable::SENSES => 0,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    RacesTable::WILD => [
                        RacesTable::STRENGTH => 3, RacesTable::AGILITY => -1, RacesTable::KNACK => -2, RacesTable::WILL => 2,
                        RacesTable::INTELLIGENCE => -3, RacesTable::CHARISMA => -2, RacesTable::ENDURANCE => 0,
                        RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => true, RacesTable::SENSES => 0,
                        RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                RacesTable::ORC => [
                    RacesTable::COMMON => [
                        RacesTable::STRENGTH => 0, RacesTable::AGILITY => 2, RacesTable::KNACK => 0, RacesTable::WILL => -1,
                        RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => -2, RacesTable::ENDURANCE => 0,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 1,
                        RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                    RacesTable::SKURUT => [
                        RacesTable::STRENGTH => 1, RacesTable::AGILITY => 1, RacesTable::KNACK => -1, RacesTable::WILL => 0,
                        RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => -2, RacesTable::ENDURANCE => 0,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 1,
                        RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                    RacesTable::GOBLIN => [
                        RacesTable::STRENGTH => -1, RacesTable::AGILITY => 2, RacesTable::KNACK => 1, RacesTable::WILL => -2,
                        RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => -1, RacesTable::ENDURANCE => 0,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 1,
                        RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
            ],
            $racesTable->getValues()
        );
    }
}
