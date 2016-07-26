<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\GenderCode;
use DrdPlus\Codes\PropertyCode;
use DrdPlus\Codes\RaceCode;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tests\Tables\TableTestInterface;

class RacesTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{

    /**
     * @test
     */
    public function I_can_get_header()
    {
        $racesTable = new RacesTable();
        self::assertEquals(
            [[
                RacesTable::RACE,
                RacesTable::SUBRACE,
                PropertyCode::STRENGTH,
                PropertyCode::AGILITY,
                PropertyCode::KNACK,
                PropertyCode::WILL,
                PropertyCode::INTELLIGENCE,
                PropertyCode::CHARISMA,
                PropertyCode::TOUGHNESS,
                PropertyCode::HEIGHT_IN_CM,
                PropertyCode::WEIGHT_IN_KG,
                PropertyCode::SIZE,
                PropertyCode::SENSES,
                PropertyCode::REMARKABLE_SENSE,
                PropertyCode::INFRAVISION,
                PropertyCode::NATIVE_REGENERATION,
                PropertyCode::REQUIRES_DM_AGREEMENT
            ]],
            $racesTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_values_in_simple_structure()
    {
        $racesTable = new RacesTable();
        self::assertEquals(
            [
                [RaceCode::HUMAN, RaceCode::COMMON, 0, 0, 0, 0, 0, 0, 0, 180.0, 80.0, 0, 0, '', false, false, false],
                [RaceCode::HUMAN, RaceCode::HIGHLANDER, 1, 0, 0, 1, -1, -1, 0, 180.0, 80.0, 0, 0, '', false, false, false],
                [RaceCode::ELF, RaceCode::COMMON, -1, 1, 1, -2, 1, 1, -1, 160.0, 50.0, -1, 0, PropertyCode::SIGHT, false, false, false],
                [RaceCode::ELF, RaceCode::GREEN, -1, 1, 0, -1, 1, 1, -1, 160.0, 50.0, -1, 0, PropertyCode::SIGHT, false, false, false],
                [RaceCode::ELF, RaceCode::DARK, 0, 0, 0, 0, 1, 0, -1, 160.0, 50.0, -1, 0, PropertyCode::SIGHT, true, false, true],
                [RaceCode::DWARF, RaceCode::COMMON, 1, -1, 0, 2, -1, -2, 1, 140.0, 70.0, 0, -1, PropertyCode::TOUCH, true, false, false],
                [RaceCode::DWARF, RaceCode::WOOD, 1, -1, 0, 1, -1, -1, 1, 140.0, 70.0, 0, -1, PropertyCode::TOUCH, true, false, false],
                [RaceCode::DWARF, RaceCode::MOUNTAIN, 2, -1, 0, 2, -2, -2, 1, 140.0, 70.0, 0, -1, PropertyCode::TOUCH, true, false, false],
                [RaceCode::HOBBIT, RaceCode::COMMON, -3, 1, 1, 0, -1, 2, 0, 110.0, 40.0, -2, 0, PropertyCode::TASTE, false, false, false],
                [RaceCode::KROLL, RaceCode::COMMON, 3, -2, -1, 1, -3, -1, 0, 220.0, 120.0, 3, 0, PropertyCode::HEARING, false, true, false],
                [RaceCode::KROLL, RaceCode::WILD, 3, -1, -2, 2, -3, -2, 0, 220.0, 120.0, 3, 0, PropertyCode::HEARING, false, true, true],
                [RaceCode::ORC, RaceCode::COMMON, 0, 2, 0, -1, 0, -2, 0, 160.0, 60.0, -1, 1, PropertyCode::SMELL, true, false, true],
                [RaceCode::ORC, RaceCode::SKURUT, 1, 1, -1, 0, 0, -2, 0, 180.0, 90.0, 1, 1, PropertyCode::SMELL, true, false, true],
                [RaceCode::ORC, RaceCode::GOBLIN, -1, 2, 1, -2, 0, -1, 0, 150.0, 55.0, -1, 1, PropertyCode::SMELL, true, false, true],
            ],
            $racesTable->getValues()
        );
    }

    /**
     * @test
     */
    public function I_can_get_common_human_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonHumanModifiers();
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 0,
                PropertyCode::AGILITY => 0,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => 0,
                PropertyCode::INTELLIGENCE => 0,
                PropertyCode::CHARISMA => 0,
                PropertyCode::TOUGHNESS => 0,
                PropertyCode::HEIGHT_IN_CM => 180.0,
                PropertyCode::WEIGHT_IN_KG => 80.0,
                PropertyCode::SIZE => 0,
                PropertyCode::SENSES => 0,
                PropertyCode::REMARKABLE_SENSE => '',
                PropertyCode::INFRAVISION => false,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 1,
                PropertyCode::AGILITY => 0,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => 1,
                PropertyCode::INTELLIGENCE => -1,
                PropertyCode::CHARISMA => -1,
                PropertyCode::TOUGHNESS => 0,
                PropertyCode::HEIGHT_IN_CM => 180.0,
                PropertyCode::WEIGHT_IN_KG => 80.0,
                PropertyCode::SIZE => 0,
                PropertyCode::SENSES => 0,
                PropertyCode::REMARKABLE_SENSE => '',
                PropertyCode::INFRAVISION => false,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
            ],
            $modifiers
        );
    }

    /**
     * @test
     */
    public function I_can_get_common_dwarf_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonDwarfModifiers();
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 1,
                PropertyCode::AGILITY => -1,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => 2,
                PropertyCode::INTELLIGENCE => -1,
                PropertyCode::CHARISMA => -2,
                PropertyCode::TOUGHNESS => 1,
                PropertyCode::HEIGHT_IN_CM => 140.0,
                PropertyCode::WEIGHT_IN_KG => 70.0,
                PropertyCode::SIZE => 0,
                PropertyCode::SENSES => -1,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::TOUCH,
                PropertyCode::INFRAVISION => true,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 1,
                PropertyCode::AGILITY => -1,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => 1,
                PropertyCode::INTELLIGENCE => -1,
                PropertyCode::CHARISMA => -1,
                PropertyCode::TOUGHNESS => 1,
                PropertyCode::HEIGHT_IN_CM => 140.0,
                PropertyCode::WEIGHT_IN_KG => 70.0,
                PropertyCode::SIZE => 0,
                PropertyCode::SENSES => -1,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::TOUCH,
                PropertyCode::INFRAVISION => true,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 2,
                PropertyCode::AGILITY => -1,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => 2,
                PropertyCode::INTELLIGENCE => -2,
                PropertyCode::CHARISMA => -2,
                PropertyCode::TOUGHNESS => 1,
                PropertyCode::HEIGHT_IN_CM => 140.0,
                PropertyCode::WEIGHT_IN_KG => 70.0,
                PropertyCode::SIZE => 0,
                PropertyCode::SENSES => -1,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::TOUCH,
                PropertyCode::INFRAVISION => true,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -1,
                PropertyCode::AGILITY => 1,
                PropertyCode::KNACK => 1,
                PropertyCode::WILL => -2,
                PropertyCode::INTELLIGENCE => 1,
                PropertyCode::CHARISMA => 1,
                PropertyCode::TOUGHNESS => -1,
                PropertyCode::HEIGHT_IN_CM => 160.0,
                PropertyCode::WEIGHT_IN_KG => 50.0,
                PropertyCode::SIZE => -1,
                PropertyCode::SENSES => 0,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::SIGHT,
                PropertyCode::INFRAVISION => false,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 0,
                PropertyCode::AGILITY => 0,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => 0,
                PropertyCode::INTELLIGENCE => 1,
                PropertyCode::CHARISMA => 0,
                PropertyCode::TOUGHNESS => -1,
                PropertyCode::HEIGHT_IN_CM => 160.0,
                PropertyCode::WEIGHT_IN_KG => 50.0,
                PropertyCode::SIZE => -1,
                PropertyCode::SENSES => 0,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::SIGHT,
                PropertyCode::INFRAVISION => true,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => true
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -1,
                PropertyCode::AGILITY => 1,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => -1,
                PropertyCode::INTELLIGENCE => 1,
                PropertyCode::CHARISMA => 1,
                PropertyCode::TOUGHNESS => -1,
                PropertyCode::HEIGHT_IN_CM => 160.0,
                PropertyCode::WEIGHT_IN_KG => 50.0,
                PropertyCode::SIZE => -1,
                PropertyCode::SENSES => 0,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::SIGHT,
                PropertyCode::INFRAVISION => false,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -3,
                PropertyCode::AGILITY => 1,
                PropertyCode::KNACK => 1,
                PropertyCode::WILL => 0,
                PropertyCode::INTELLIGENCE => -1,
                PropertyCode::CHARISMA => 2,
                PropertyCode::TOUGHNESS => 0,
                PropertyCode::HEIGHT_IN_CM => 110.0,
                PropertyCode::WEIGHT_IN_KG => 40.0,
                PropertyCode::SIZE => -2,
                PropertyCode::SENSES => 0,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::TASTE,
                PropertyCode::INFRAVISION => false,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 3,
                PropertyCode::AGILITY => -2,
                PropertyCode::KNACK => -1,
                PropertyCode::WILL => 1,
                PropertyCode::INTELLIGENCE => -3,
                PropertyCode::CHARISMA => -1,
                PropertyCode::TOUGHNESS => 0,
                PropertyCode::HEIGHT_IN_CM => 220.0,
                PropertyCode::WEIGHT_IN_KG => 120.0,
                PropertyCode::SIZE => 3,
                PropertyCode::SENSES => 0,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::HEARING,
                PropertyCode::INFRAVISION => false,
                PropertyCode::NATIVE_REGENERATION => true,
                PropertyCode::REQUIRES_DM_AGREEMENT => false
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 3,
                PropertyCode::AGILITY => -1,
                PropertyCode::KNACK => -2,
                PropertyCode::WILL => 2,
                PropertyCode::INTELLIGENCE => -3,
                PropertyCode::CHARISMA => -2,
                PropertyCode::TOUGHNESS => 0,
                PropertyCode::HEIGHT_IN_CM => 220.0,
                PropertyCode::WEIGHT_IN_KG => 120.0,
                PropertyCode::SIZE => 3,
                PropertyCode::SENSES => 0,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::HEARING,
                PropertyCode::INFRAVISION => false,
                PropertyCode::NATIVE_REGENERATION => true,
                PropertyCode::REQUIRES_DM_AGREEMENT => true
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 0,
                PropertyCode::AGILITY => 2,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => -1,
                PropertyCode::INTELLIGENCE => 0,
                PropertyCode::CHARISMA => -2,
                PropertyCode::TOUGHNESS => 0,
                PropertyCode::HEIGHT_IN_CM => 160.0,
                PropertyCode::WEIGHT_IN_KG => 60.0,
                PropertyCode::SIZE => -1,
                PropertyCode::SENSES => 1,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::SMELL,
                PropertyCode::INFRAVISION => true,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => true
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 1,
                PropertyCode::AGILITY => 1,
                PropertyCode::KNACK => -1,
                PropertyCode::WILL => 0,
                PropertyCode::INTELLIGENCE => 0,
                PropertyCode::CHARISMA => -2,
                PropertyCode::TOUGHNESS => 0,
                PropertyCode::HEIGHT_IN_CM => 180.0,
                PropertyCode::WEIGHT_IN_KG => 90.0,
                PropertyCode::SIZE => 1,
                PropertyCode::SENSES => 1,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::SMELL,
                PropertyCode::INFRAVISION => true,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => true
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
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -1,
                PropertyCode::AGILITY => 2,
                PropertyCode::KNACK => 1,
                PropertyCode::WILL => -2,
                PropertyCode::INTELLIGENCE => 0,
                PropertyCode::CHARISMA => -1,
                PropertyCode::TOUGHNESS => 0,
                PropertyCode::HEIGHT_IN_CM => 150.0,
                PropertyCode::WEIGHT_IN_KG => 55.0,
                PropertyCode::SIZE => -1,
                PropertyCode::SENSES => 1,
                PropertyCode::REMARKABLE_SENSE => PropertyCode::SMELL,
                PropertyCode::INFRAVISION => true,
                PropertyCode::NATIVE_REGENERATION => false,
                PropertyCode::REQUIRES_DM_AGREEMENT => true
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
        self::assertSame(
            [
                RaceCode::HUMAN => [
                    RaceCode::COMMON => [
                        PropertyCode::STRENGTH => 0, PropertyCode::AGILITY => 0, PropertyCode::KNACK => 0, PropertyCode::WILL => 0,
                        PropertyCode::INTELLIGENCE => 0, PropertyCode::CHARISMA => 0, PropertyCode::TOUGHNESS => 0,
                        PropertyCode::HEIGHT_IN_CM => 180.0, PropertyCode::WEIGHT_IN_KG => 80.0, PropertyCode::SIZE => 0,
                        PropertyCode::SENSES => 0, PropertyCode::REMARKABLE_SENSE => '',
                        PropertyCode::INFRAVISION => false, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCode::HIGHLANDER => [PropertyCode::STRENGTH => 1, PropertyCode::AGILITY => 0, PropertyCode::KNACK => 0,
                        PropertyCode::WILL => 1, PropertyCode::INTELLIGENCE => -1, PropertyCode::CHARISMA => -1,
                        PropertyCode::TOUGHNESS => 0,
                        PropertyCode::HEIGHT_IN_CM => 180.0, PropertyCode::WEIGHT_IN_KG => 80.0, PropertyCode::SIZE => 0,
                        PropertyCode::SENSES => 0, PropertyCode::REMARKABLE_SENSE => '',
                        PropertyCode::INFRAVISION => false, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RaceCode::ELF => [
                    RaceCode::COMMON => [
                        PropertyCode::STRENGTH => -1, PropertyCode::AGILITY => 1, PropertyCode::KNACK => 1,
                        PropertyCode::WILL => -2, PropertyCode::INTELLIGENCE => 1, PropertyCode::CHARISMA => 1,
                        PropertyCode::TOUGHNESS => -1,
                        PropertyCode::HEIGHT_IN_CM => 160.0, PropertyCode::WEIGHT_IN_KG => 50.0, PropertyCode::SIZE => -1,
                        PropertyCode::SENSES => 0, PropertyCode::REMARKABLE_SENSE => PropertyCode::SIGHT,
                        PropertyCode::INFRAVISION => false, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCode::GREEN => [
                        PropertyCode::STRENGTH => -1, PropertyCode::AGILITY => 1, PropertyCode::KNACK => 0,
                        PropertyCode::WILL => -1, PropertyCode::INTELLIGENCE => 1, PropertyCode::CHARISMA => 1,
                        PropertyCode::TOUGHNESS => -1,
                        PropertyCode::HEIGHT_IN_CM => 160.0, PropertyCode::WEIGHT_IN_KG => 50.0, PropertyCode::SIZE => -1,
                        PropertyCode::SENSES => 0, PropertyCode::REMARKABLE_SENSE => PropertyCode::SIGHT,
                        PropertyCode::INFRAVISION => false, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCode::DARK => [
                        PropertyCode::STRENGTH => 0, PropertyCode::AGILITY => 0, PropertyCode::KNACK => 0,
                        PropertyCode::WILL => 0, PropertyCode::INTELLIGENCE => 1, PropertyCode::CHARISMA => 0,
                        PropertyCode::TOUGHNESS => -1,
                        PropertyCode::HEIGHT_IN_CM => 160.0, PropertyCode::WEIGHT_IN_KG => 50.0, PropertyCode::SIZE => -1,
                        PropertyCode::SENSES => 0, PropertyCode::REMARKABLE_SENSE => PropertyCode::SIGHT,
                        PropertyCode::INFRAVISION => true, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                RaceCode::DWARF => [
                    RaceCode::COMMON => [
                        PropertyCode::STRENGTH => 1, PropertyCode::AGILITY => -1, PropertyCode::KNACK => 0, PropertyCode::WILL => 2,
                        PropertyCode::INTELLIGENCE => -1, PropertyCode::CHARISMA => -2, PropertyCode::TOUGHNESS => 1,
                        PropertyCode::HEIGHT_IN_CM => 140.0, PropertyCode::WEIGHT_IN_KG => 70.0, PropertyCode::SIZE => 0,
                        PropertyCode::SENSES => -1, PropertyCode::REMARKABLE_SENSE => PropertyCode::TOUCH,
                        PropertyCode::INFRAVISION => true, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCode::WOOD => [
                        PropertyCode::STRENGTH => 1, PropertyCode::AGILITY => -1, PropertyCode::KNACK => 0, PropertyCode::WILL => 1,
                        PropertyCode::INTELLIGENCE => -1, PropertyCode::CHARISMA => -1, PropertyCode::TOUGHNESS => 1,
                        PropertyCode::HEIGHT_IN_CM => 140.0, PropertyCode::WEIGHT_IN_KG => 70.0, PropertyCode::SIZE => 0,
                        PropertyCode::SENSES => -1, PropertyCode::REMARKABLE_SENSE => PropertyCode::TOUCH,
                        PropertyCode::INFRAVISION => true, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCode::MOUNTAIN => [
                        PropertyCode::STRENGTH => 2, PropertyCode::AGILITY => -1, PropertyCode::KNACK => 0, PropertyCode::WILL => 2,
                        PropertyCode::INTELLIGENCE => -2, PropertyCode::CHARISMA => -2, PropertyCode::TOUGHNESS => 1,
                        PropertyCode::HEIGHT_IN_CM => 140.0, PropertyCode::WEIGHT_IN_KG => 70.0, PropertyCode::SIZE => 0,
                        PropertyCode::SENSES => -1, PropertyCode::REMARKABLE_SENSE => PropertyCode::TOUCH,
                        PropertyCode::INFRAVISION => true, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RaceCode::HOBBIT => [
                    RaceCode::COMMON => [
                        PropertyCode::STRENGTH => -3, PropertyCode::AGILITY => 1, PropertyCode::KNACK => 1, PropertyCode::WILL => 0,
                        PropertyCode::INTELLIGENCE => -1, PropertyCode::CHARISMA => 2, PropertyCode::TOUGHNESS => 0,
                        PropertyCode::HEIGHT_IN_CM => 110.0, PropertyCode::WEIGHT_IN_KG => 40.0, PropertyCode::SIZE => -2,
                        PropertyCode::SENSES => 0, PropertyCode::REMARKABLE_SENSE => PropertyCode::TASTE,
                        PropertyCode::INFRAVISION => false, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RaceCode::KROLL => [
                    RaceCode::COMMON => [
                        PropertyCode::STRENGTH => 3, PropertyCode::AGILITY => -2, PropertyCode::KNACK => -1, PropertyCode::WILL => 1,
                        PropertyCode::INTELLIGENCE => -3, PropertyCode::CHARISMA => -1, PropertyCode::TOUGHNESS => 0,
                        PropertyCode::HEIGHT_IN_CM => 220.0, PropertyCode::WEIGHT_IN_KG => 120.0, PropertyCode::SIZE => 3,
                        PropertyCode::SENSES => 0, PropertyCode::REMARKABLE_SENSE => PropertyCode::HEARING,
                        PropertyCode::INFRAVISION => false, PropertyCode::NATIVE_REGENERATION => true,
                        PropertyCode::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCode::WILD => [
                        PropertyCode::STRENGTH => 3, PropertyCode::AGILITY => -1, PropertyCode::KNACK => -2, PropertyCode::WILL => 2,
                        PropertyCode::INTELLIGENCE => -3, PropertyCode::CHARISMA => -2, PropertyCode::TOUGHNESS => 0,
                        PropertyCode::HEIGHT_IN_CM => 220.0, PropertyCode::WEIGHT_IN_KG => 120.0, PropertyCode::SIZE => 3,
                        PropertyCode::SENSES => 0, PropertyCode::REMARKABLE_SENSE => PropertyCode::HEARING,
                        PropertyCode::INFRAVISION => false, PropertyCode::NATIVE_REGENERATION => true,
                        PropertyCode::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                RaceCode::ORC => [
                    RaceCode::COMMON => [
                        PropertyCode::STRENGTH => 0, PropertyCode::AGILITY => 2, PropertyCode::KNACK => 0, PropertyCode::WILL => -1,
                        PropertyCode::INTELLIGENCE => 0, PropertyCode::CHARISMA => -2, PropertyCode::TOUGHNESS => 0,
                        PropertyCode::HEIGHT_IN_CM => 160.0, PropertyCode::WEIGHT_IN_KG => 60.0, PropertyCode::SIZE => -1,
                        PropertyCode::SENSES => 1, PropertyCode::REMARKABLE_SENSE => PropertyCode::SMELL,
                        PropertyCode::INFRAVISION => true, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => true
                    ],
                    RaceCode::SKURUT => [
                        PropertyCode::STRENGTH => 1, PropertyCode::AGILITY => 1, PropertyCode::KNACK => -1, PropertyCode::WILL => 0,
                        PropertyCode::INTELLIGENCE => 0, PropertyCode::CHARISMA => -2, PropertyCode::TOUGHNESS => 0,
                        PropertyCode::HEIGHT_IN_CM => 180.0, PropertyCode::WEIGHT_IN_KG => 90.0, PropertyCode::SIZE => 1,
                        PropertyCode::SENSES => 1, PropertyCode::REMARKABLE_SENSE => PropertyCode::SMELL,
                        PropertyCode::INFRAVISION => true, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => true
                    ],
                    RaceCode::GOBLIN => [
                        PropertyCode::STRENGTH => -1, PropertyCode::AGILITY => 2, PropertyCode::KNACK => 1, PropertyCode::WILL => -2,
                        PropertyCode::INTELLIGENCE => 0, PropertyCode::CHARISMA => -1, PropertyCode::TOUGHNESS => 0,
                        PropertyCode::HEIGHT_IN_CM => 150.0, PropertyCode::WEIGHT_IN_KG => 55.0, PropertyCode::SIZE => -1,
                        PropertyCode::SENSES => 1, PropertyCode::REMARKABLE_SENSE => PropertyCode::SMELL,
                        PropertyCode::INFRAVISION => true, PropertyCode::NATIVE_REGENERATION => false,
                        PropertyCode::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
            ],
            $racesTable->getIndexedValues()
        );
    }

    /**
     * @test
     * @dataProvider provideStrengthOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $maleStrength
     * @param int $femaleStrength
     */
    public function I_can_get_strength_of_any_race($race, $subrace, $maleStrength, $femaleStrength)
    {
        $racesTable = new RacesTable();
        self::assertSame($maleStrength, $racesTable->getMaleStrength($race, $subrace));
        self::assertSame($femaleStrength, $racesTable->getFemaleStrength($race, $subrace, new FemaleModifiersTable()));
    }

    public function provideStrengthOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0, -1],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 1, 0],
            [RaceCode::ELF, RaceCode::COMMON, -1, -2],
            [RaceCode::ELF, RaceCode::GREEN, -1, -2],
            [RaceCode::ELF, RaceCode::DARK, 0, -1],
            [RaceCode::DWARF, RaceCode::COMMON, 1, 1],
            [RaceCode::DWARF, RaceCode::WOOD, 1, 1],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, 2, 2],
            [RaceCode::HOBBIT, RaceCode::COMMON, -3, -4],
            [RaceCode::KROLL, RaceCode::COMMON, 3, 2],
            [RaceCode::KROLL, RaceCode::WILD, 3, 2],
            [RaceCode::ORC, RaceCode::COMMON, 0, -1],
            [RaceCode::ORC, RaceCode::SKURUT, 1, 0],
            [RaceCode::ORC, RaceCode::GOBLIN, -1, -2],
        ];
    }

    /**
     * @test
     * @dataProvider provideAgilityOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $maleAgility
     * @param int $femaleAgility
     */
    public function I_can_get_agility_of_any_race($race, $subrace, $maleAgility, $femaleAgility)
    {
        $racesTable = new RacesTable();
        self::assertSame($maleAgility, $racesTable->getMaleAgility($race, $subrace));
        self::assertSame($femaleAgility, $racesTable->getFemaleAgility($race, $subrace, new FemaleModifiersTable()));
    }

    public function provideAgilityOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0, 0],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 0, 0],
            [RaceCode::ELF, RaceCode::COMMON, 1, 1],
            [RaceCode::ELF, RaceCode::GREEN, 1, 1],
            [RaceCode::ELF, RaceCode::DARK, 0, 0],
            [RaceCode::DWARF, RaceCode::COMMON, -1, -1],
            [RaceCode::DWARF, RaceCode::WOOD, -1, -1],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, -1, -1],
            [RaceCode::HOBBIT, RaceCode::COMMON, 1, 2],
            [RaceCode::KROLL, RaceCode::COMMON, -2, -1],
            [RaceCode::KROLL, RaceCode::WILD, -1, 0],
            [RaceCode::ORC, RaceCode::COMMON, 2, 2],
            [RaceCode::ORC, RaceCode::SKURUT, 1, 1],
            [RaceCode::ORC, RaceCode::GOBLIN, 2, 2],
        ];
    }

    /**
     * @test
     * @dataProvider provideKnackOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $maleKnack
     * @param int $femaleKnack
     */
    public function I_can_get_knack_of_any_race($race, $subrace, $maleKnack, $femaleKnack)
    {
        $racesTable = new RacesTable();
        self::assertSame($maleKnack, $racesTable->getMaleKnack($race, $subrace));
        self::assertSame($femaleKnack, $racesTable->getFemaleKnack($race, $subrace, new FemaleModifiersTable()));
    }

    public function provideKnackOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0, 0],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 0, 0],
            [RaceCode::ELF, RaceCode::COMMON, 1, 2],
            [RaceCode::ELF, RaceCode::GREEN, 0, 1],
            [RaceCode::ELF, RaceCode::DARK, 0, 1],
            [RaceCode::DWARF, RaceCode::COMMON, 0, -1],
            [RaceCode::DWARF, RaceCode::WOOD, 0, -1],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, 0, -1],
            [RaceCode::HOBBIT, RaceCode::COMMON, 1, 0],
            [RaceCode::KROLL, RaceCode::COMMON, -1, -1],
            [RaceCode::KROLL, RaceCode::WILD, -2, -2],
            [RaceCode::ORC, RaceCode::COMMON, 0, 0],
            [RaceCode::ORC, RaceCode::SKURUT, -1, -1],
            [RaceCode::ORC, RaceCode::GOBLIN, 1, 1],
        ];
    }

    /**
     * @test
     * @dataProvider provideWillOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $maleWill
     * @param int $femaleWill
     */
    public function I_can_get_will_of_any_race($race, $subrace, $maleWill, $femaleWill)
    {
        $racesTable = new RacesTable();
        self::assertSame($maleWill, $racesTable->getMaleWill($race, $subrace));
        self::assertSame($femaleWill, $racesTable->getFemaleWill($race, $subrace, new FemaleModifiersTable()));
    }

    public function provideWillOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0, 0],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 1, 1],
            [RaceCode::ELF, RaceCode::COMMON, -2, -2],
            [RaceCode::ELF, RaceCode::GREEN, -1, -1],
            [RaceCode::ELF, RaceCode::DARK, 0, 0],
            [RaceCode::DWARF, RaceCode::COMMON, 2, 2],
            [RaceCode::DWARF, RaceCode::WOOD, 1, 1],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, 2, 2],
            [RaceCode::HOBBIT, RaceCode::COMMON, 0, 0],
            [RaceCode::KROLL, RaceCode::COMMON, 1, 0],
            [RaceCode::KROLL, RaceCode::WILD, 2, 1],
            [RaceCode::ORC, RaceCode::COMMON, -1, 0],
            [RaceCode::ORC, RaceCode::SKURUT, 0, 1],
            [RaceCode::ORC, RaceCode::GOBLIN, -2, -1],
        ];
    }

    /**
     * @test
     * @dataProvider provideIntelligenceOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $maleIntelligence
     * @param int $femaleIntelligence
     */
    public function I_can_get_intelligence_of_any_race($race, $subrace, $maleIntelligence, $femaleIntelligence)
    {
        $racesTable = new RacesTable();
        self::assertSame($maleIntelligence, $racesTable->getMaleIntelligence($race, $subrace));
        self::assertSame($femaleIntelligence, $racesTable->getFemaleIntelligence($race, $subrace, new FemaleModifiersTable()));
    }

    public function provideIntelligenceOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0, 0],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, -1, -1],
            [RaceCode::ELF, RaceCode::COMMON, 1, 0],
            [RaceCode::ELF, RaceCode::GREEN, 1, 0],
            [RaceCode::ELF, RaceCode::DARK, 1, 0],
            [RaceCode::DWARF, RaceCode::COMMON, -1, 0],
            [RaceCode::DWARF, RaceCode::WOOD, -1, 0],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, -2, -1],
            [RaceCode::HOBBIT, RaceCode::COMMON, -1, -1],
            [RaceCode::KROLL, RaceCode::COMMON, -3, -3],
            [RaceCode::KROLL, RaceCode::WILD, -3, -3],
            [RaceCode::ORC, RaceCode::COMMON, 0, 0],
            [RaceCode::ORC, RaceCode::SKURUT, 0, 0],
            [RaceCode::ORC, RaceCode::GOBLIN, 0, 0],
        ];
    }

    /**
     * @test
     * @dataProvider provideCharismaOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $maleCharisma
     * @param int $femaleCharisma
     */
    public function I_can_get_charisma_of_any_race($race, $subrace, $maleCharisma, $femaleCharisma)
    {
        $racesTable = new RacesTable();
        self::assertSame($maleCharisma, $racesTable->getMaleCharisma($race, $subrace));
        self::assertSame($femaleCharisma, $racesTable->getFemaleCharisma($race, $subrace, new FemaleModifiersTable()));
    }

    public function provideCharismaOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0, 1],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, -1, 0],
            [RaceCode::ELF, RaceCode::COMMON, 1, 2],
            [RaceCode::ELF, RaceCode::GREEN, 1, 2],
            [RaceCode::ELF, RaceCode::DARK, 0, 1],
            [RaceCode::DWARF, RaceCode::COMMON, -2, -2],
            [RaceCode::DWARF, RaceCode::WOOD, -1, -1],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, -2, -2],
            [RaceCode::HOBBIT, RaceCode::COMMON, 2, 3],
            [RaceCode::KROLL, RaceCode::COMMON, -1, 0],
            [RaceCode::KROLL, RaceCode::WILD, -2, -1],
            [RaceCode::ORC, RaceCode::COMMON, -2, -2],
            [RaceCode::ORC, RaceCode::SKURUT, -2, -2],
            [RaceCode::ORC, RaceCode::GOBLIN, -1, -1],
        ];
    }

    /**
     * @test
     * @dataProvider provideToughnessOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $toughness
     */
    public function I_can_get_toughness_of_any_race($race, $subrace, $toughness)
    {
        $racesTable = new RacesTable();
        self::assertSame($toughness, $racesTable->getToughness($race, $subrace));
    }

    public function provideToughnessOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 0],
            [RaceCode::ELF, RaceCode::COMMON, -1],
            [RaceCode::ELF, RaceCode::GREEN, -1],
            [RaceCode::ELF, RaceCode::DARK, -1],
            [RaceCode::DWARF, RaceCode::COMMON, 1],
            [RaceCode::DWARF, RaceCode::WOOD, 1],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, 1],
            [RaceCode::HOBBIT, RaceCode::COMMON, 0],
            [RaceCode::KROLL, RaceCode::COMMON, 0],
            [RaceCode::KROLL, RaceCode::WILD, 0],
            [RaceCode::ORC, RaceCode::COMMON, 0],
            [RaceCode::ORC, RaceCode::SKURUT, 0],
            [RaceCode::ORC, RaceCode::GOBLIN, 0],
        ];
    }

    /**
     * @test
     * @dataProvider provideHeightOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $heightInCm
     */
    public function I_can_get_height_of_any_race($race, $subrace, $heightInCm)
    {
        $racesTable = new RacesTable();
        self::assertSame($heightInCm, $racesTable->getHeightInCm($race, $subrace));
    }

    public function provideHeightOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 180.0],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 180.0],
            [RaceCode::ELF, RaceCode::COMMON, 160.0],
            [RaceCode::ELF, RaceCode::GREEN, 160.0],
            [RaceCode::ELF, RaceCode::DARK, 160.0],
            [RaceCode::DWARF, RaceCode::COMMON, 140.0],
            [RaceCode::DWARF, RaceCode::WOOD, 140.0],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, 140.0],
            [RaceCode::HOBBIT, RaceCode::COMMON, 110.0],
            [RaceCode::KROLL, RaceCode::COMMON, 220.0],
            [RaceCode::KROLL, RaceCode::WILD, 220.0],
            [RaceCode::ORC, RaceCode::COMMON, 160.0],
            [RaceCode::ORC, RaceCode::SKURUT, 180.0],
            [RaceCode::ORC, RaceCode::GOBLIN, 150.0],
        ];
    }

    /**
     * @test
     * @dataProvider provideWeightOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $maleWeightInKg
     * @param int $femaleWeightInKg
     */
    public function I_can_get_weight_of_any_race($race, $subrace, $maleWeightInKg, $femaleWeightInKg)
    {
        $racesTable = new RacesTable();
        self::assertSame($maleWeightInKg, $racesTable->getMaleWeightInKg($race, $subrace));
        $femaleModifiersTable = new FemaleModifiersTable();
        $weightTable = new WeightTable();
        self::assertSame(
            $femaleWeightInKg,
            $racesTable->getFemaleWeightInKg($race, $subrace, $femaleModifiersTable, $weightTable)
        );
        self::assertSame(
            $maleWeightInKg,
            $racesTable->getWeightInKg($race, $subrace, GenderCode::MALE, $femaleModifiersTable, $weightTable)
        );
        self::assertSame(
            $femaleWeightInKg,
            $racesTable->getWeightInKg($race, $subrace, GenderCode::FEMALE, $femaleModifiersTable, $weightTable)
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Races\Exceptions\UnknownGender
     */
    public function I_can_not_get_weight_of_unknown_gender()
    {
        $racesTable = new RacesTable();
        $racesTable->getWeightInKg(
            RaceCode::HUMAN,
            RaceCode::COMMON,
            'not from this universe',
            new FemaleModifiersTable(),
            new WeightTable()
        );
    }

    public function provideWeightOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 80.0, 70.0],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 80.0, 70.0],
            [RaceCode::ELF, RaceCode::COMMON, 50.0, 45.0],
            [RaceCode::ELF, RaceCode::GREEN, 50.0, 45.0],
            [RaceCode::ELF, RaceCode::DARK, 50.0, 45.0],
            [RaceCode::DWARF, RaceCode::COMMON, 70.0, 70.0],
            [RaceCode::DWARF, RaceCode::WOOD, 70.0, 70.0],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, 70.0, 70.0],
            [RaceCode::HOBBIT, RaceCode::COMMON, 40.0, 36.0],
            [RaceCode::KROLL, RaceCode::COMMON, 120.0, 110.0],
            [RaceCode::KROLL, RaceCode::WILD, 120.0, 110.0],
            [RaceCode::ORC, RaceCode::COMMON, 60.0, 56.0],
            [RaceCode::ORC, RaceCode::SKURUT, 90.0, 80.0],
            [RaceCode::ORC, RaceCode::GOBLIN, 55.0, 50.0],
        ];
    }

    /**
     * @test
     * @dataProvider provideSizeOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $maleSize
     * @param int $femaleSize
     */
    public function I_can_get_size_of_any_race($race, $subrace, $maleSize, $femaleSize)
    {
        $racesTable = new RacesTable();
        $femaleModifiersTable = new FemaleModifiersTable();

        self::assertSame($maleSize, $racesTable->getMaleSize($race, $subrace));
        self::assertSame($maleSize, $racesTable->getSize($race, $subrace, GenderCode::MALE, $femaleModifiersTable));

        self::assertSame($femaleSize, $racesTable->getFemaleSize($race, $subrace, $femaleModifiersTable));
        self::assertSame($femaleSize, $racesTable->getSize($race, $subrace, GenderCode::FEMALE, $femaleModifiersTable));
    }

    public function provideSizeOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0, -1],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 0, -1],
            [RaceCode::ELF, RaceCode::COMMON, -1, -2],
            [RaceCode::ELF, RaceCode::GREEN, -1, -2],
            [RaceCode::ELF, RaceCode::DARK, -1, -2],
            [RaceCode::DWARF, RaceCode::COMMON, 0, 0],
            [RaceCode::DWARF, RaceCode::WOOD, 0, 0],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, 0, 0],
            [RaceCode::HOBBIT, RaceCode::COMMON, -2, -3],
            [RaceCode::KROLL, RaceCode::COMMON, 3, 2],
            [RaceCode::KROLL, RaceCode::WILD, 3, 2],
            [RaceCode::ORC, RaceCode::COMMON, -1, -2],
            [RaceCode::ORC, RaceCode::SKURUT, 1, 0],
            [RaceCode::ORC, RaceCode::GOBLIN, -1, -2],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Races\Exceptions\UnknownGender
     */
    public function I_can_not_get_size_for_unknown_gender()
    {
        $racesTable = new RacesTable();
        $racesTable->getSize(RaceCode::HUMAN, RaceCode::COMMON, 'unknown gender', new FemaleModifiersTable());
    }

    /**
     * @test
     * @dataProvider provideSensesOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param int $senses
     */
    public function I_can_get_senses_of_any_race($race, $subrace, $senses)
    {
        $racesTable = new RacesTable();
        self::assertSame($senses, $racesTable->getSenses($race, $subrace));
    }

    public function provideSensesOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, 0],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, 0],
            [RaceCode::ELF, RaceCode::COMMON, 0],
            [RaceCode::ELF, RaceCode::GREEN, 0],
            [RaceCode::ELF, RaceCode::DARK, 0],
            [RaceCode::DWARF, RaceCode::COMMON, -1],
            [RaceCode::DWARF, RaceCode::WOOD, -1],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, -1],
            [RaceCode::HOBBIT, RaceCode::COMMON, 0],
            [RaceCode::KROLL, RaceCode::COMMON, 0],
            [RaceCode::KROLL, RaceCode::WILD, 0],
            [RaceCode::ORC, RaceCode::COMMON, 1],
            [RaceCode::ORC, RaceCode::SKURUT, 1],
            [RaceCode::ORC, RaceCode::GOBLIN, 1],
        ];
    }

    /**
     * @test
     * @dataProvider provideRemarkableSenseOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param string $remarkableSense
     */
    public function I_can_get_remarkable_sense_of_any_race($race, $subrace, $remarkableSense)
    {
        $racesTable = new RacesTable();
        self::assertSame($remarkableSense, $racesTable->getRemarkableSense($race, $subrace));
    }

    public function provideRemarkableSenseOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, ''],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, ''],
            [RaceCode::ELF, RaceCode::COMMON, PropertyCode::SIGHT],
            [RaceCode::ELF, RaceCode::GREEN, PropertyCode::SIGHT],
            [RaceCode::ELF, RaceCode::DARK, PropertyCode::SIGHT],
            [RaceCode::DWARF, RaceCode::COMMON, PropertyCode::TOUCH],
            [RaceCode::DWARF, RaceCode::WOOD, PropertyCode::TOUCH],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, PropertyCode::TOUCH],
            [RaceCode::HOBBIT, RaceCode::COMMON, PropertyCode::TASTE],
            [RaceCode::KROLL, RaceCode::COMMON, PropertyCode::HEARING],
            [RaceCode::KROLL, RaceCode::WILD, PropertyCode::HEARING],
            [RaceCode::ORC, RaceCode::COMMON, PropertyCode::SMELL],
            [RaceCode::ORC, RaceCode::SKURUT, PropertyCode::SMELL],
            [RaceCode::ORC, RaceCode::GOBLIN, PropertyCode::SMELL],
        ];
    }

    /**
     * @test
     * @dataProvider provideInfravisionOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param bool $infravision
     */
    public function I_can_get_infravision_of_any_race($race, $subrace, $infravision)
    {
        $racesTable = new RacesTable();
        self::assertSame($infravision, $racesTable->hasInfravision($race, $subrace));
    }

    public function provideInfravisionOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, false],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, false],
            [RaceCode::ELF, RaceCode::COMMON, false],
            [RaceCode::ELF, RaceCode::GREEN, false],
            [RaceCode::ELF, RaceCode::DARK, true],
            [RaceCode::DWARF, RaceCode::COMMON, true],
            [RaceCode::DWARF, RaceCode::WOOD, true],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, true],
            [RaceCode::HOBBIT, RaceCode::COMMON, false],
            [RaceCode::KROLL, RaceCode::COMMON, false],
            [RaceCode::KROLL, RaceCode::WILD, false],
            [RaceCode::ORC, RaceCode::COMMON, true],
            [RaceCode::ORC, RaceCode::SKURUT, true],
            [RaceCode::ORC, RaceCode::GOBLIN, true],
        ];
    }

    /**
     * @test
     * @dataProvider provideNativeRegenerationOfRace
     *
     * @param string $race
     * @param string $subrace
     * @param bool $nativeRegeneration
     */
    public function I_can_get_nativeRegeneration_of_any_race($race, $subrace, $nativeRegeneration)
    {
        $racesTable = new RacesTable();
        self::assertSame($nativeRegeneration, $racesTable->hasNativeRegeneration($race, $subrace));
    }

    public function provideNativeRegenerationOfRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, false],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, false],
            [RaceCode::ELF, RaceCode::COMMON, false],
            [RaceCode::ELF, RaceCode::GREEN, false],
            [RaceCode::ELF, RaceCode::DARK, false],
            [RaceCode::DWARF, RaceCode::COMMON, false],
            [RaceCode::DWARF, RaceCode::WOOD, false],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, false],
            [RaceCode::HOBBIT, RaceCode::COMMON, false],
            [RaceCode::KROLL, RaceCode::COMMON, true],
            [RaceCode::KROLL, RaceCode::WILD, true],
            [RaceCode::ORC, RaceCode::COMMON, false],
            [RaceCode::ORC, RaceCode::SKURUT, false],
            [RaceCode::ORC, RaceCode::GOBLIN, false],
        ];
    }

    /**
     * @test
     * @dataProvider provideRequirementOfDmForRace
     *
     * @param string $race
     * @param string $subrace
     * @param bool $requiredDmAgreement
     */
    public function I_can_detect_requirement_of_dm_agreement_of_any_race($race, $subrace, $requiredDmAgreement)
    {
        $racesTable = new RacesTable();
        self::assertSame($requiredDmAgreement, $racesTable->requiresDmAgreement($race, $subrace));
    }

    public function provideRequirementOfDmForRace()
    {
        return [
            [RaceCode::HUMAN, RaceCode::COMMON, false],
            [RaceCode::HUMAN, RaceCode::HIGHLANDER, false],
            [RaceCode::ELF, RaceCode::COMMON, false],
            [RaceCode::ELF, RaceCode::GREEN, false],
            [RaceCode::ELF, RaceCode::DARK, true],
            [RaceCode::DWARF, RaceCode::COMMON, false],
            [RaceCode::DWARF, RaceCode::WOOD, false],
            [RaceCode::DWARF, RaceCode::MOUNTAIN, false],
            [RaceCode::HOBBIT, RaceCode::COMMON, false],
            [RaceCode::KROLL, RaceCode::COMMON, false],
            [RaceCode::KROLL, RaceCode::WILD, true],
            [RaceCode::ORC, RaceCode::COMMON, true],
            [RaceCode::ORC, RaceCode::SKURUT, true],
            [RaceCode::ORC, RaceCode::GOBLIN, true],
        ];
    }
}
