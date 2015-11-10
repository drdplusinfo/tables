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

    /**
     * @test
     * @dataProvider strengthOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $strength
     */
    public function I_can_get_strength_of_any_race($race, $subrace, $strength)
    {
        $racesTable = new RacesTable();
        $this->assertSame($strength, $racesTable->getStrength($race, $subrace));
    }

    public function strengthOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, 0],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, 1],
            [RacesTable::ELF, RacesTable::COMMON, -1],
            [RacesTable::ELF, RacesTable::GREEN, -1],
            [RacesTable::ELF, RacesTable::DARK, 0],
            [RacesTable::DWARF, RacesTable::COMMON, 1],
            [RacesTable::DWARF, RacesTable::WOOD, 1],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, 2],
            [RacesTable::HOBBIT, RacesTable::COMMON, -3],
            [RacesTable::KROLL, RacesTable::COMMON, 3],
            [RacesTable::KROLL, RacesTable::WILD, 3],
            [RacesTable::ORC, RacesTable::COMMON, 0],
            [RacesTable::ORC, RacesTable::SKURUT, 1],
            [RacesTable::ORC, RacesTable::GOBLIN, -1],
        ];
    }

    /**
     * @test
     * @dataProvider agilityOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $agility
     */
    public function I_can_get_agility_of_any_race($race, $subrace, $agility)
    {
        $racesTable = new RacesTable();
        $this->assertSame($agility, $racesTable->getAgility($race, $subrace));
    }

    public function agilityOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, 0],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, 0],
            [RacesTable::ELF, RacesTable::COMMON, 1],
            [RacesTable::ELF, RacesTable::GREEN, 1],
            [RacesTable::ELF, RacesTable::DARK, 0],
            [RacesTable::DWARF, RacesTable::COMMON, -1],
            [RacesTable::DWARF, RacesTable::WOOD, -1],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, -1],
            [RacesTable::HOBBIT, RacesTable::COMMON, 1],
            [RacesTable::KROLL, RacesTable::COMMON, -2],
            [RacesTable::KROLL, RacesTable::WILD, -1],
            [RacesTable::ORC, RacesTable::COMMON, 2],
            [RacesTable::ORC, RacesTable::SKURUT, 1],
            [RacesTable::ORC, RacesTable::GOBLIN, 2],
        ];
    }

    /**
     * @test
     * @dataProvider knackOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $knack
     */
    public function I_can_get_knack_of_any_race($race, $subrace, $knack)
    {
        $racesTable = new RacesTable();
        $this->assertSame($knack, $racesTable->getKnack($race, $subrace));
    }

    public function knackOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, 0],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, 0],
            [RacesTable::ELF, RacesTable::COMMON, 1],
            [RacesTable::ELF, RacesTable::GREEN, 0],
            [RacesTable::ELF, RacesTable::DARK, 0],
            [RacesTable::DWARF, RacesTable::COMMON, 0],
            [RacesTable::DWARF, RacesTable::WOOD, 0],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, 0],
            [RacesTable::HOBBIT, RacesTable::COMMON, 1],
            [RacesTable::KROLL, RacesTable::COMMON, -1],
            [RacesTable::KROLL, RacesTable::WILD, -2],
            [RacesTable::ORC, RacesTable::COMMON, 0],
            [RacesTable::ORC, RacesTable::SKURUT, -1],
            [RacesTable::ORC, RacesTable::GOBLIN, 1],
        ];
    }

    /**
     * @test
     * @dataProvider willOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $will
     */
    public function I_can_get_will_of_any_race($race, $subrace, $will)
    {
        $racesTable = new RacesTable();
        $this->assertSame($will, $racesTable->getWill($race, $subrace));
    }

    public function willOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, 0],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, 1],
            [RacesTable::ELF, RacesTable::COMMON, -2],
            [RacesTable::ELF, RacesTable::GREEN, -1],
            [RacesTable::ELF, RacesTable::DARK, 0],
            [RacesTable::DWARF, RacesTable::COMMON, 2],
            [RacesTable::DWARF, RacesTable::WOOD, 1],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, 2],
            [RacesTable::HOBBIT, RacesTable::COMMON, 0],
            [RacesTable::KROLL, RacesTable::COMMON, 1],
            [RacesTable::KROLL, RacesTable::WILD, 2],
            [RacesTable::ORC, RacesTable::COMMON, -1],
            [RacesTable::ORC, RacesTable::SKURUT, 0],
            [RacesTable::ORC, RacesTable::GOBLIN, -2],
        ];
    }

    /**
     * @test
     * @dataProvider intelligenceOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $intelligence
     */
    public function I_can_get_intelligence_of_any_race($race, $subrace, $intelligence)
    {
        $racesTable = new RacesTable();
        $this->assertSame($intelligence, $racesTable->getIntelligence($race, $subrace));
    }

    public function intelligenceOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, 0],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, -1],
            [RacesTable::ELF, RacesTable::COMMON, 1],
            [RacesTable::ELF, RacesTable::GREEN, 1],
            [RacesTable::ELF, RacesTable::DARK, 1],
            [RacesTable::DWARF, RacesTable::COMMON, -1],
            [RacesTable::DWARF, RacesTable::WOOD, -1],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, -2],
            [RacesTable::HOBBIT, RacesTable::COMMON, -1],
            [RacesTable::KROLL, RacesTable::COMMON, -3],
            [RacesTable::KROLL, RacesTable::WILD, -3],
            [RacesTable::ORC, RacesTable::COMMON, 0],
            [RacesTable::ORC, RacesTable::SKURUT, 0],
            [RacesTable::ORC, RacesTable::GOBLIN, 0],
        ];
    }

    /**
     * @test
     * @dataProvider charismaOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $charisma
     */
    public function I_can_get_charisma_of_any_race($race, $subrace, $charisma)
    {
        $racesTable = new RacesTable();
        $this->assertSame($charisma, $racesTable->getCharisma($race, $subrace));
    }

    public function charismaOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, 0],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, -1],
            [RacesTable::ELF, RacesTable::COMMON, 1],
            [RacesTable::ELF, RacesTable::GREEN, 1],
            [RacesTable::ELF, RacesTable::DARK, 0],
            [RacesTable::DWARF, RacesTable::COMMON, -2],
            [RacesTable::DWARF, RacesTable::WOOD, -1],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, -2],
            [RacesTable::HOBBIT, RacesTable::COMMON, 2],
            [RacesTable::KROLL, RacesTable::COMMON, -1],
            [RacesTable::KROLL, RacesTable::WILD, -2],
            [RacesTable::ORC, RacesTable::COMMON, -2],
            [RacesTable::ORC, RacesTable::SKURUT, -2],
            [RacesTable::ORC, RacesTable::GOBLIN, -1],
        ];
    }

    /**
     * @test
     * @dataProvider enduranceOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $endurance
     */
    public function I_can_get_endurance_of_any_race($race, $subrace, $endurance)
    {
        $racesTable = new RacesTable();
        $this->assertSame($endurance, $racesTable->getEndurance($race, $subrace));
    }

    public function enduranceOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, 0],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, 0],
            [RacesTable::ELF, RacesTable::COMMON, -1],
            [RacesTable::ELF, RacesTable::GREEN, -1],
            [RacesTable::ELF, RacesTable::DARK, -1],
            [RacesTable::DWARF, RacesTable::COMMON, 1],
            [RacesTable::DWARF, RacesTable::WOOD, 1],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, 1],
            [RacesTable::HOBBIT, RacesTable::COMMON, 0],
            [RacesTable::KROLL, RacesTable::COMMON, 0],
            [RacesTable::KROLL, RacesTable::WILD, 0],
            [RacesTable::ORC, RacesTable::COMMON, 0],
            [RacesTable::ORC, RacesTable::SKURUT, 0],
            [RacesTable::ORC, RacesTable::GOBLIN, 0],
        ];
    }

    /**
     * @test
     * @dataProvider infravisionOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param bool $infravision
     */
    public function I_can_get_infravision_of_any_race($race, $subrace, $infravision)
    {
        $racesTable = new RacesTable();
        $this->assertSame($infravision, $racesTable->getInfravision($race, $subrace));
    }

    public function infravisionOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, false],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, false],
            [RacesTable::ELF, RacesTable::COMMON, false],
            [RacesTable::ELF, RacesTable::GREEN, false],
            [RacesTable::ELF, RacesTable::DARK, true],
            [RacesTable::DWARF, RacesTable::COMMON, true],
            [RacesTable::DWARF, RacesTable::WOOD, true],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, true],
            [RacesTable::HOBBIT, RacesTable::COMMON, false],
            [RacesTable::KROLL, RacesTable::COMMON, false],
            [RacesTable::KROLL, RacesTable::WILD, false],
            [RacesTable::ORC, RacesTable::COMMON, true],
            [RacesTable::ORC, RacesTable::SKURUT, true],
            [RacesTable::ORC, RacesTable::GOBLIN, true],
        ];
    }

    /**
     * @test
     * @dataProvider nativeRegenerationOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param bool $nativeRegeneration
     */
    public function I_can_get_nativeRegeneration_of_any_race($race, $subrace, $nativeRegeneration)
    {
        $racesTable = new RacesTable();
        $this->assertSame($nativeRegeneration, $racesTable->getNativeRegeneration($race, $subrace));
    }

    public function nativeRegenerationOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, false],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, false],
            [RacesTable::ELF, RacesTable::COMMON, false],
            [RacesTable::ELF, RacesTable::GREEN, false],
            [RacesTable::ELF, RacesTable::DARK, false],
            [RacesTable::DWARF, RacesTable::COMMON, false],
            [RacesTable::DWARF, RacesTable::WOOD, false],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, false],
            [RacesTable::HOBBIT, RacesTable::COMMON, false],
            [RacesTable::KROLL, RacesTable::COMMON, true],
            [RacesTable::KROLL, RacesTable::WILD, true],
            [RacesTable::ORC, RacesTable::COMMON, false],
            [RacesTable::ORC, RacesTable::SKURUT, false],
            [RacesTable::ORC, RacesTable::GOBLIN, false],
        ];
    }

    /**
     * @test
     * @dataProvider sensesOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $senses
     */
    public function I_can_get_senses_of_any_race($race, $subrace, $senses)
    {
        $racesTable = new RacesTable();
        $this->assertSame($senses, $racesTable->getSenses($race, $subrace));
    }

    public function sensesOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, 0],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, 0],
            [RacesTable::ELF, RacesTable::COMMON, 0],
            [RacesTable::ELF, RacesTable::GREEN, 0],
            [RacesTable::ELF, RacesTable::DARK, 0],
            [RacesTable::DWARF, RacesTable::COMMON, -1],
            [RacesTable::DWARF, RacesTable::WOOD, -1],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, -1],
            [RacesTable::HOBBIT, RacesTable::COMMON, 0],
            [RacesTable::KROLL, RacesTable::COMMON, 0],
            [RacesTable::KROLL, RacesTable::WILD, 0],
            [RacesTable::ORC, RacesTable::COMMON, 1],
            [RacesTable::ORC, RacesTable::SKURUT, 1],
            [RacesTable::ORC, RacesTable::GOBLIN, 1],
        ];
    }

    /**
     * @test
     * @dataProvider requirementOfDmOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param bool $requiredDmAgreement
     */
    public function I_can_detect_requirement_of_dm_agreement_of_any_race($race, $subrace, $requiredDmAgreement)
    {
        $racesTable = new RacesTable();
        $this->assertSame($requiredDmAgreement, $racesTable->requiresDmAgreement($race, $subrace));
    }

    public function requirementOfDmOfRaces()
    {
        return [
            [RacesTable::HUMAN, RacesTable::COMMON, false],
            [RacesTable::HUMAN, RacesTable::HIGHLANDER, false],
            [RacesTable::ELF, RacesTable::COMMON, false],
            [RacesTable::ELF, RacesTable::GREEN, false],
            [RacesTable::ELF, RacesTable::DARK, true],
            [RacesTable::DWARF, RacesTable::COMMON, false],
            [RacesTable::DWARF, RacesTable::WOOD, false],
            [RacesTable::DWARF, RacesTable::MOUNTAIN, false],
            [RacesTable::HOBBIT, RacesTable::COMMON, false],
            [RacesTable::KROLL, RacesTable::COMMON, false],
            [RacesTable::KROLL, RacesTable::WILD, true],
            [RacesTable::ORC, RacesTable::COMMON, true],
            [RacesTable::ORC, RacesTable::SKURUT, true],
            [RacesTable::ORC, RacesTable::GOBLIN, true],
        ];
    }
}
