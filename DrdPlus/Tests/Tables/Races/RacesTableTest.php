<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Races\Dwarfs\CommonDwarf;
use DrdPlus\Races\Dwarfs\Dwarf;
use DrdPlus\Races\Dwarfs\MountainDwarf;
use DrdPlus\Races\Dwarfs\WoodDwarf;
use DrdPlus\Races\Elfs\CommonElf;
use DrdPlus\Races\Elfs\DarkElf;
use DrdPlus\Races\Elfs\Elf;
use DrdPlus\Races\Elfs\GreenElf;
use DrdPlus\Races\Hobbits\CommonHobbit;
use DrdPlus\Races\Hobbits\Hobbit;
use DrdPlus\Races\Humans\CommonHuman;
use DrdPlus\Races\Humans\Highlander;
use DrdPlus\Races\Humans\Human;
use DrdPlus\Races\Krolls\CommonKroll;
use DrdPlus\Races\Krolls\Kroll;
use DrdPlus\Races\Krolls\WildKroll;
use DrdPlus\Races\Orcs\CommonOrc;
use DrdPlus\Races\Orcs\Goblin;
use DrdPlus\Races\Orcs\Orc;
use DrdPlus\Races\Orcs\Skurut;

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
                RacesTable::TOUGHNESS => 1,
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
                RacesTable::TOUGHNESS => 1,
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
                RacesTable::TOUGHNESS => 1,
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
                RacesTable::TOUGHNESS => -1,
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
                RacesTable::TOUGHNESS => -1,
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
                RacesTable::TOUGHNESS => -1,
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
                RacesTable::TOUGHNESS => 0,
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
                RacesTable::TOUGHNESS => 0,
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
                RacesTable::TOUGHNESS => 0,
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
                RacesTable::TOUGHNESS => 0,
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
                RacesTable::TOUGHNESS => 0,
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
                RacesTable::TOUGHNESS => 0,
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
                RacesTable::TOUGHNESS => 0,
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
                RacesTable::TOUGHNESS => 0,
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
                Human::HUMAN => [
                    CommonHuman::COMMON => [
                        RacesTable::STRENGTH => 0, RacesTable::AGILITY => 0, RacesTable::KNACK => 0, RacesTable::WILL => 0,
                        RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => 0, RacesTable::TOUGHNESS => 0,
                        RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 0,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    Highlander::HIGHLANDER => [RacesTable::STRENGTH => 1, RacesTable::AGILITY => 0, RacesTable::KNACK => 0,
                        RacesTable::WILL => 1, RacesTable::INTELLIGENCE => -1, RacesTable::CHARISMA => -1,
                        RacesTable::TOUGHNESS => 0, RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => false,
                        RacesTable::SENSES => 0, RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                Elf::ELF => [
                    CommonElf::COMMON => [
                        RacesTable::STRENGTH => -1, RacesTable::AGILITY => 1, RacesTable::KNACK => 1,
                        RacesTable::WILL => -2, RacesTable::INTELLIGENCE => 1, RacesTable::CHARISMA => 1,
                        RacesTable::TOUGHNESS => -1, RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => false,
                        RacesTable::SENSES => 0, RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    GreenElf::GREEN => [
                        RacesTable::STRENGTH => -1, RacesTable::AGILITY => 1, RacesTable::KNACK => 0,
                        RacesTable::WILL => -1, RacesTable::INTELLIGENCE => 1, RacesTable::CHARISMA => 1,
                        RacesTable::TOUGHNESS => -1, RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION =>
                            false, RacesTable::SENSES => 0, RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    DarkElf::DARK => [
                        RacesTable::STRENGTH => 0, RacesTable::AGILITY => 0, RacesTable::KNACK => 0,
                        RacesTable::WILL => 0, RacesTable::INTELLIGENCE => 1, RacesTable::CHARISMA => 0,
                        RacesTable::TOUGHNESS => -1, RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false,
                        RacesTable::SENSES => 0, RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                Dwarf::DWARF => [
                    CommonDwarf::COMMON => [
                        RacesTable::STRENGTH => 1, RacesTable::AGILITY => -1, RacesTable::KNACK => 0, RacesTable::WILL => 2,
                        RacesTable::INTELLIGENCE => -1, RacesTable::CHARISMA => -2, RacesTable::TOUGHNESS => 1,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => -1,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    WoodDwarf::WOOD => [
                        RacesTable::STRENGTH => 1, RacesTable::AGILITY => -1, RacesTable::KNACK => 0, RacesTable::WILL => 1,
                        RacesTable::INTELLIGENCE => -1, RacesTable::CHARISMA => -1, RacesTable::TOUGHNESS => 1,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => -1,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    MountainDwarf::MOUNTAIN => [
                        RacesTable::STRENGTH => 2, RacesTable::AGILITY => -1, RacesTable::KNACK => 0, RacesTable::WILL => 2,
                        RacesTable::INTELLIGENCE => -2, RacesTable::CHARISMA => -2, RacesTable::TOUGHNESS => 1,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => -1,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                Hobbit::HOBBIT => [
                    CommonHobbit::COMMON => [
                        RacesTable::STRENGTH => -3, RacesTable::AGILITY => 1, RacesTable::KNACK => 1, RacesTable::WILL => 0,
                        RacesTable::INTELLIGENCE => -1, RacesTable::CHARISMA => 2, RacesTable::TOUGHNESS => 0,
                        RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 0,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                Kroll::KROLL => [
                    CommonKroll::COMMON => [
                        RacesTable::STRENGTH => 3, RacesTable::AGILITY => -2, RacesTable::KNACK => -1, RacesTable::WILL => 1,
                        RacesTable::INTELLIGENCE => -3, RacesTable::CHARISMA => -1, RacesTable::TOUGHNESS => 0,
                        RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => true, RacesTable::SENSES => 0,
                        RacesTable::REQUIRES_DM_AGREEMENT => false
                    ],
                    WildKroll::WILD => [
                        RacesTable::STRENGTH => 3, RacesTable::AGILITY => -1, RacesTable::KNACK => -2, RacesTable::WILL => 2,
                        RacesTable::INTELLIGENCE => -3, RacesTable::CHARISMA => -2, RacesTable::TOUGHNESS => 0,
                        RacesTable::INFRAVISION => false, RacesTable::NATIVE_REGENERATION => true, RacesTable::SENSES => 0,
                        RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                Orc::ORC => [
                    CommonOrc::COMMON => [
                        RacesTable::STRENGTH => 0, RacesTable::AGILITY => 2, RacesTable::KNACK => 0, RacesTable::WILL => -1,
                        RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => -2, RacesTable::TOUGHNESS => 0,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 1,
                        RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                    Skurut::SKURUT => [
                        RacesTable::STRENGTH => 1, RacesTable::AGILITY => 1, RacesTable::KNACK => -1, RacesTable::WILL => 0,
                        RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => -2, RacesTable::TOUGHNESS => 0,
                        RacesTable::INFRAVISION => true, RacesTable::NATIVE_REGENERATION => false, RacesTable::SENSES => 1,
                        RacesTable::REQUIRES_DM_AGREEMENT => true
                    ],
                    Goblin::GOBLIN => [
                        RacesTable::STRENGTH => -1, RacesTable::AGILITY => 2, RacesTable::KNACK => 1, RacesTable::WILL => -2,
                        RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => -1, RacesTable::TOUGHNESS => 0,
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
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, 1],
            [Elf::ELF, CommonElf::COMMON, -1],
            [Elf::ELF, GreenElf::GREEN, -1],
            [Elf::ELF, DarkElf::DARK, 0],
            [Dwarf::DWARF, CommonDwarf::COMMON, 1],
            [Dwarf::DWARF, WoodDwarf::WOOD, 1],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, 2],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, -3],
            [Kroll::KROLL, CommonKroll::COMMON, 3],
            [Kroll::KROLL, WildKroll::WILD, 3],
            [Orc::ORC, CommonOrc::COMMON, 0],
            [Orc::ORC, Skurut::SKURUT, 1],
            [Orc::ORC, Goblin::GOBLIN, -1],
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
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, 0],
            [Elf::ELF, CommonElf::COMMON, 1],
            [Elf::ELF, GreenElf::GREEN, 1],
            [Elf::ELF, DarkElf::DARK, 0],
            [Dwarf::DWARF, CommonDwarf::COMMON, -1],
            [Dwarf::DWARF, WoodDwarf::WOOD, -1],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, -1],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, 1],
            [Kroll::KROLL, CommonKroll::COMMON, -2],
            [Kroll::KROLL, WildKroll::WILD, -1],
            [Orc::ORC, CommonOrc::COMMON, 2],
            [Orc::ORC, Skurut::SKURUT, 1],
            [Orc::ORC, Goblin::GOBLIN, 2],
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
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, 0],
            [Elf::ELF, CommonElf::COMMON, 1],
            [Elf::ELF, GreenElf::GREEN, 0],
            [Elf::ELF, DarkElf::DARK, 0],
            [Dwarf::DWARF, CommonDwarf::COMMON, 0],
            [Dwarf::DWARF, WoodDwarf::WOOD, 0],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, 0],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, 1],
            [Kroll::KROLL, CommonKroll::COMMON, -1],
            [Kroll::KROLL, WildKroll::WILD, -2],
            [Orc::ORC, CommonOrc::COMMON, 0],
            [Orc::ORC, Skurut::SKURUT, -1],
            [Orc::ORC, Goblin::GOBLIN, 1],
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
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, 1],
            [Elf::ELF, CommonElf::COMMON, -2],
            [Elf::ELF, GreenElf::GREEN, -1],
            [Elf::ELF, DarkElf::DARK, 0],
            [Dwarf::DWARF, CommonDwarf::COMMON, 2],
            [Dwarf::DWARF, WoodDwarf::WOOD, 1],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, 2],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, 0],
            [Kroll::KROLL, CommonKroll::COMMON, 1],
            [Kroll::KROLL, WildKroll::WILD, 2],
            [Orc::ORC, CommonOrc::COMMON, -1],
            [Orc::ORC, Skurut::SKURUT, 0],
            [Orc::ORC, Goblin::GOBLIN, -2],
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
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, -1],
            [Elf::ELF, CommonElf::COMMON, 1],
            [Elf::ELF, GreenElf::GREEN, 1],
            [Elf::ELF, DarkElf::DARK, 1],
            [Dwarf::DWARF, CommonDwarf::COMMON, -1],
            [Dwarf::DWARF, WoodDwarf::WOOD, -1],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, -2],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, -1],
            [Kroll::KROLL, CommonKroll::COMMON, -3],
            [Kroll::KROLL, WildKroll::WILD, -3],
            [Orc::ORC, CommonOrc::COMMON, 0],
            [Orc::ORC, Skurut::SKURUT, 0],
            [Orc::ORC, Goblin::GOBLIN, 0],
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
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, -1],
            [Elf::ELF, CommonElf::COMMON, 1],
            [Elf::ELF, GreenElf::GREEN, 1],
            [Elf::ELF, DarkElf::DARK, 0],
            [Dwarf::DWARF, CommonDwarf::COMMON, -2],
            [Dwarf::DWARF, WoodDwarf::WOOD, -1],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, -2],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, 2],
            [Kroll::KROLL, CommonKroll::COMMON, -1],
            [Kroll::KROLL, WildKroll::WILD, -2],
            [Orc::ORC, CommonOrc::COMMON, -2],
            [Orc::ORC, Skurut::SKURUT, -2],
            [Orc::ORC, Goblin::GOBLIN, -1],
        ];
    }

    /**
     * @test
     * @dataProvider toughnessOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $toughness
     */
    public function I_can_get_toughness_of_any_race($race, $subrace, $toughness)
    {
        $racesTable = new RacesTable();
        $this->assertSame($toughness, $racesTable->getToughness($race, $subrace));
    }

    public function toughnessOfRaces()
    {
        return [
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, 0],
            [Elf::ELF, CommonElf::COMMON, -1],
            [Elf::ELF, GreenElf::GREEN, -1],
            [Elf::ELF, DarkElf::DARK, -1],
            [Dwarf::DWARF, CommonDwarf::COMMON, 1],
            [Dwarf::DWARF, WoodDwarf::WOOD, 1],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, 1],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, 0],
            [Kroll::KROLL, CommonKroll::COMMON, 0],
            [Kroll::KROLL, WildKroll::WILD, 0],
            [Orc::ORC, CommonOrc::COMMON, 0],
            [Orc::ORC, Skurut::SKURUT, 0],
            [Orc::ORC, Goblin::GOBLIN, 0],
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
        $this->assertSame($infravision, $racesTable->hasInfravision($race, $subrace));
    }

    public function infravisionOfRaces()
    {
        return [
            [Human::HUMAN, CommonHuman::COMMON, false],
            [Human::HUMAN, Highlander::HIGHLANDER, false],
            [Elf::ELF, CommonElf::COMMON, false],
            [Elf::ELF, GreenElf::GREEN, false],
            [Elf::ELF, DarkElf::DARK, true],
            [Dwarf::DWARF, CommonDwarf::COMMON, true],
            [Dwarf::DWARF, WoodDwarf::WOOD, true],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, true],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, false],
            [Kroll::KROLL, CommonKroll::COMMON, false],
            [Kroll::KROLL, WildKroll::WILD, false],
            [Orc::ORC, CommonOrc::COMMON, true],
            [Orc::ORC, Skurut::SKURUT, true],
            [Orc::ORC, Goblin::GOBLIN, true],
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
        $this->assertSame($nativeRegeneration, $racesTable->hasNativeRegeneration($race, $subrace));
    }

    public function nativeRegenerationOfRaces()
    {
        return [
            [Human::HUMAN, CommonHuman::COMMON, false],
            [Human::HUMAN, Highlander::HIGHLANDER, false],
            [Elf::ELF, CommonElf::COMMON, false],
            [Elf::ELF, GreenElf::GREEN, false],
            [Elf::ELF, DarkElf::DARK, false],
            [Dwarf::DWARF, CommonDwarf::COMMON, false],
            [Dwarf::DWARF, WoodDwarf::WOOD, false],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, false],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, false],
            [Kroll::KROLL, CommonKroll::COMMON, true],
            [Kroll::KROLL, WildKroll::WILD, true],
            [Orc::ORC, CommonOrc::COMMON, false],
            [Orc::ORC, Skurut::SKURUT, false],
            [Orc::ORC, Goblin::GOBLIN, false],
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
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, 0],
            [Elf::ELF, CommonElf::COMMON, 0],
            [Elf::ELF, GreenElf::GREEN, 0],
            [Elf::ELF, DarkElf::DARK, 0],
            [Dwarf::DWARF, CommonDwarf::COMMON, -1],
            [Dwarf::DWARF, WoodDwarf::WOOD, -1],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, -1],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, 0],
            [Kroll::KROLL, CommonKroll::COMMON, 0],
            [Kroll::KROLL, WildKroll::WILD, 0],
            [Orc::ORC, CommonOrc::COMMON, 1],
            [Orc::ORC, Skurut::SKURUT, 1],
            [Orc::ORC, Goblin::GOBLIN, 1],
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
            [Human::HUMAN, CommonHuman::COMMON, false],
            [Human::HUMAN, Highlander::HIGHLANDER, false],
            [Elf::ELF, CommonElf::COMMON, false],
            [Elf::ELF, GreenElf::GREEN, false],
            [Elf::ELF, DarkElf::DARK, true],
            [Dwarf::DWARF, CommonDwarf::COMMON, false],
            [Dwarf::DWARF, WoodDwarf::WOOD, false],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, false],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, false],
            [Kroll::KROLL, CommonKroll::COMMON, false],
            [Kroll::KROLL, WildKroll::WILD, true],
            [Orc::ORC, CommonOrc::COMMON, true],
            [Orc::ORC, Skurut::SKURUT, true],
            [Orc::ORC, Goblin::GOBLIN, true],
        ];
    }
}
