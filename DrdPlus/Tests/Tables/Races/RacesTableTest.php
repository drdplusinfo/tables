<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\GenderCodes;
use DrdPlus\Codes\PropertyCodes;
use DrdPlus\Codes\RaceCodes;
use DrdPlus\Tables\Measurements\Weight\WeightTable;

class RacesTableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function I_can_get_headers()
    {
        $racesTable = new RacesTable();
        self::assertEquals(
            [[
                RacesTable::RACE,
                RacesTable::SUBRACE,
                PropertyCodes::STRENGTH,
                PropertyCodes::AGILITY,
                PropertyCodes::KNACK,
                PropertyCodes::WILL,
                PropertyCodes::INTELLIGENCE,
                PropertyCodes::CHARISMA,
                PropertyCodes::TOUGHNESS,
                PropertyCodes::HEIGHT_IN_CM,
                PropertyCodes::WEIGHT_IN_KG,
                PropertyCodes::SIZE,
                PropertyCodes::SENSES,
                PropertyCodes::REMARKABLE_SENSE,
                PropertyCodes::INFRAVISION,
                PropertyCodes::NATIVE_REGENERATION,
                PropertyCodes::REQUIRES_DM_AGREEMENT
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
                [RaceCodes::HUMAN, RaceCodes::COMMON, 0, 0, 0, 0, 0, 0, 0, 180.0, 80.0, 0, 0, '', false, false, false],
                [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 1, 0, 0, 1, -1, -1, 0, 180.0, 80.0, 0, 0, '', false, false, false],
                [RaceCodes::ELF, RaceCodes::COMMON, -1, 1, 1, -2, 1, 1, -1, 160.0, 50.0, -1, 0, PropertyCodes::SIGHT, false, false, false],
                [RaceCodes::ELF, RaceCodes::GREEN, -1, 1, 0, -1, 1, 1, -1, 160.0, 50.0, -1, 0, PropertyCodes::SIGHT, false, false, false],
                [RaceCodes::ELF, RaceCodes::DARK, 0, 0, 0, 0, 1, 0, -1, 160.0, 50.0, -1, 0, PropertyCodes::SIGHT, true, false, true],
                [RaceCodes::DWARF, RaceCodes::COMMON, 1, -1, 0, 2, -1, -2, 1, 140.0, 70.0, 0, -1, PropertyCodes::TOUCH, true, false, false],
                [RaceCodes::DWARF, RaceCodes::WOOD, 1, -1, 0, 1, -1, -1, 1, 140.0, 70.0, 0, -1, PropertyCodes::TOUCH, true, false, false],
                [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 2, -1, 0, 2, -2, -2, 1, 140.0, 70.0, 0, -1, PropertyCodes::TOUCH, true, false, false],
                [RaceCodes::HOBBIT, RaceCodes::COMMON, -3, 1, 1, 0, -1, 2, 0, 110.0, 40.0, -2, 0, PropertyCodes::TASTE, false, false, false],
                [RaceCodes::KROLL, RaceCodes::COMMON, 3, -2, -1, 1, -3, -1, 0, 220.0, 120.0, 3, 0, PropertyCodes::HEARING, false, true, false],
                [RaceCodes::KROLL, RaceCodes::WILD, 3, -1, -2, 2, -3, -2, 0, 220.0, 120.0, 3, 0, PropertyCodes::HEARING, false, true, true],
                [RaceCodes::ORC, RaceCodes::COMMON, 0, 2, 0, -1, 0, -2, 0, 160.0, 60.0, -1, 1, PropertyCodes::SMELL, true, false, true],
                [RaceCodes::ORC, RaceCodes::SKURUT, 1, 1, -1, 0, 0, -2, 0, 180.0, 90.0, 1, 1, PropertyCodes::SMELL, true, false, true],
                [RaceCodes::ORC, RaceCodes::GOBLIN, -1, 2, 1, -2, 0, -1, 0, 150.0, 55.0, -1, 1, PropertyCodes::SMELL, true, false, true],
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
                PropertyCodes::STRENGTH => 0,
                PropertyCodes::AGILITY => 0,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => 0,
                PropertyCodes::INTELLIGENCE => 0,
                PropertyCodes::CHARISMA => 0,
                PropertyCodes::TOUGHNESS => 0,
                PropertyCodes::HEIGHT_IN_CM => 180.0,
                PropertyCodes::WEIGHT_IN_KG => 80.0,
                PropertyCodes::SIZE => 0,
                PropertyCodes::SENSES => 0,
                PropertyCodes::REMARKABLE_SENSE => '',
                PropertyCodes::INFRAVISION => false,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => 1,
                PropertyCodes::AGILITY => 0,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => 1,
                PropertyCodes::INTELLIGENCE => -1,
                PropertyCodes::CHARISMA => -1,
                PropertyCodes::TOUGHNESS => 0,
                PropertyCodes::HEIGHT_IN_CM => 180.0,
                PropertyCodes::WEIGHT_IN_KG => 80.0,
                PropertyCodes::SIZE => 0,
                PropertyCodes::SENSES => 0,
                PropertyCodes::REMARKABLE_SENSE => '',
                PropertyCodes::INFRAVISION => false,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => 1,
                PropertyCodes::AGILITY => -1,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => 2,
                PropertyCodes::INTELLIGENCE => -1,
                PropertyCodes::CHARISMA => -2,
                PropertyCodes::TOUGHNESS => 1,
                PropertyCodes::HEIGHT_IN_CM => 140.0,
                PropertyCodes::WEIGHT_IN_KG => 70.0,
                PropertyCodes::SIZE => 0,
                PropertyCodes::SENSES => -1,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                PropertyCodes::INFRAVISION => true,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => 1,
                PropertyCodes::AGILITY => -1,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => 1,
                PropertyCodes::INTELLIGENCE => -1,
                PropertyCodes::CHARISMA => -1,
                PropertyCodes::TOUGHNESS => 1,
                PropertyCodes::HEIGHT_IN_CM => 140.0,
                PropertyCodes::WEIGHT_IN_KG => 70.0,
                PropertyCodes::SIZE => 0,
                PropertyCodes::SENSES => -1,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                PropertyCodes::INFRAVISION => true,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => 2,
                PropertyCodes::AGILITY => -1,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => 2,
                PropertyCodes::INTELLIGENCE => -2,
                PropertyCodes::CHARISMA => -2,
                PropertyCodes::TOUGHNESS => 1,
                PropertyCodes::HEIGHT_IN_CM => 140.0,
                PropertyCodes::WEIGHT_IN_KG => 70.0,
                PropertyCodes::SIZE => 0,
                PropertyCodes::SENSES => -1,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                PropertyCodes::INFRAVISION => true,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => -1,
                PropertyCodes::AGILITY => 1,
                PropertyCodes::KNACK => 1,
                PropertyCodes::WILL => -2,
                PropertyCodes::INTELLIGENCE => 1,
                PropertyCodes::CHARISMA => 1,
                PropertyCodes::TOUGHNESS => -1,
                PropertyCodes::HEIGHT_IN_CM => 160.0,
                PropertyCodes::WEIGHT_IN_KG => 50.0,
                PropertyCodes::SIZE => -1,
                PropertyCodes::SENSES => 0,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                PropertyCodes::INFRAVISION => false,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => 0,
                PropertyCodes::AGILITY => 0,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => 0,
                PropertyCodes::INTELLIGENCE => 1,
                PropertyCodes::CHARISMA => 0,
                PropertyCodes::TOUGHNESS => -1,
                PropertyCodes::HEIGHT_IN_CM => 160.0,
                PropertyCodes::WEIGHT_IN_KG => 50.0,
                PropertyCodes::SIZE => -1,
                PropertyCodes::SENSES => 0,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                PropertyCodes::INFRAVISION => true,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => true
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
                PropertyCodes::STRENGTH => -1,
                PropertyCodes::AGILITY => 1,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => -1,
                PropertyCodes::INTELLIGENCE => 1,
                PropertyCodes::CHARISMA => 1,
                PropertyCodes::TOUGHNESS => -1,
                PropertyCodes::HEIGHT_IN_CM => 160.0,
                PropertyCodes::WEIGHT_IN_KG => 50.0,
                PropertyCodes::SIZE => -1,
                PropertyCodes::SENSES => 0,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                PropertyCodes::INFRAVISION => false,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => -3,
                PropertyCodes::AGILITY => 1,
                PropertyCodes::KNACK => 1,
                PropertyCodes::WILL => 0,
                PropertyCodes::INTELLIGENCE => -1,
                PropertyCodes::CHARISMA => 2,
                PropertyCodes::TOUGHNESS => 0,
                PropertyCodes::HEIGHT_IN_CM => 110.0,
                PropertyCodes::WEIGHT_IN_KG => 40.0,
                PropertyCodes::SIZE => -2,
                PropertyCodes::SENSES => 0,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::TASTE,
                PropertyCodes::INFRAVISION => false,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => 3,
                PropertyCodes::AGILITY => -2,
                PropertyCodes::KNACK => -1,
                PropertyCodes::WILL => 1,
                PropertyCodes::INTELLIGENCE => -3,
                PropertyCodes::CHARISMA => -1,
                PropertyCodes::TOUGHNESS => 0,
                PropertyCodes::HEIGHT_IN_CM => 220.0,
                PropertyCodes::WEIGHT_IN_KG => 120.0,
                PropertyCodes::SIZE => 3,
                PropertyCodes::SENSES => 0,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::HEARING,
                PropertyCodes::INFRAVISION => false,
                PropertyCodes::NATIVE_REGENERATION => true,
                PropertyCodes::REQUIRES_DM_AGREEMENT => false
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
                PropertyCodes::STRENGTH => 3,
                PropertyCodes::AGILITY => -1,
                PropertyCodes::KNACK => -2,
                PropertyCodes::WILL => 2,
                PropertyCodes::INTELLIGENCE => -3,
                PropertyCodes::CHARISMA => -2,
                PropertyCodes::TOUGHNESS => 0,
                PropertyCodes::HEIGHT_IN_CM => 220.0,
                PropertyCodes::WEIGHT_IN_KG => 120.0,
                PropertyCodes::SIZE => 3,
                PropertyCodes::SENSES => 0,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::HEARING,
                PropertyCodes::INFRAVISION => false,
                PropertyCodes::NATIVE_REGENERATION => true,
                PropertyCodes::REQUIRES_DM_AGREEMENT => true
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
                PropertyCodes::STRENGTH => 0,
                PropertyCodes::AGILITY => 2,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => -1,
                PropertyCodes::INTELLIGENCE => 0,
                PropertyCodes::CHARISMA => -2,
                PropertyCodes::TOUGHNESS => 0,
                PropertyCodes::HEIGHT_IN_CM => 160.0,
                PropertyCodes::WEIGHT_IN_KG => 60.0,
                PropertyCodes::SIZE => -1,
                PropertyCodes::SENSES => 1,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SMELL,
                PropertyCodes::INFRAVISION => true,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => true
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
                PropertyCodes::STRENGTH => 1,
                PropertyCodes::AGILITY => 1,
                PropertyCodes::KNACK => -1,
                PropertyCodes::WILL => 0,
                PropertyCodes::INTELLIGENCE => 0,
                PropertyCodes::CHARISMA => -2,
                PropertyCodes::TOUGHNESS => 0,
                PropertyCodes::HEIGHT_IN_CM => 180.0,
                PropertyCodes::WEIGHT_IN_KG => 90.0,
                PropertyCodes::SIZE => 1,
                PropertyCodes::SENSES => 1,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SMELL,
                PropertyCodes::INFRAVISION => true,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => true
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
                PropertyCodes::STRENGTH => -1,
                PropertyCodes::AGILITY => 2,
                PropertyCodes::KNACK => 1,
                PropertyCodes::WILL => -2,
                PropertyCodes::INTELLIGENCE => 0,
                PropertyCodes::CHARISMA => -1,
                PropertyCodes::TOUGHNESS => 0,
                PropertyCodes::HEIGHT_IN_CM => 150.0,
                PropertyCodes::WEIGHT_IN_KG => 55.0,
                PropertyCodes::SIZE => -1,
                PropertyCodes::SENSES => 1,
                PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SMELL,
                PropertyCodes::INFRAVISION => true,
                PropertyCodes::NATIVE_REGENERATION => false,
                PropertyCodes::REQUIRES_DM_AGREEMENT => true
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
                RaceCodes::HUMAN => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => 0, PropertyCodes::AGILITY => 0, PropertyCodes::KNACK => 0, PropertyCodes::WILL => 0,
                        PropertyCodes::INTELLIGENCE => 0, PropertyCodes::CHARISMA => 0, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 180.0, PropertyCodes::WEIGHT_IN_KG => 80.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => 0, PropertyCodes::REMARKABLE_SENSE => '',
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::HIGHLANDER => [PropertyCodes::STRENGTH => 1, PropertyCodes::AGILITY => 0, PropertyCodes::KNACK => 0,
                        PropertyCodes::WILL => 1, PropertyCodes::INTELLIGENCE => -1, PropertyCodes::CHARISMA => -1,
                        PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 180.0, PropertyCodes::WEIGHT_IN_KG => 80.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => 0, PropertyCodes::REMARKABLE_SENSE => '',
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RaceCodes::ELF => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => -1, PropertyCodes::AGILITY => 1, PropertyCodes::KNACK => 1,
                        PropertyCodes::WILL => -2, PropertyCodes::INTELLIGENCE => 1, PropertyCodes::CHARISMA => 1,
                        PropertyCodes::TOUGHNESS => -1,
                        PropertyCodes::HEIGHT_IN_CM => 160.0, PropertyCodes::WEIGHT_IN_KG => 50.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 0, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::GREEN => [
                        PropertyCodes::STRENGTH => -1, PropertyCodes::AGILITY => 1, PropertyCodes::KNACK => 0,
                        PropertyCodes::WILL => -1, PropertyCodes::INTELLIGENCE => 1, PropertyCodes::CHARISMA => 1,
                        PropertyCodes::TOUGHNESS => -1,
                        PropertyCodes::HEIGHT_IN_CM => 160.0, PropertyCodes::WEIGHT_IN_KG => 50.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 0, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::DARK => [
                        PropertyCodes::STRENGTH => 0, PropertyCodes::AGILITY => 0, PropertyCodes::KNACK => 0,
                        PropertyCodes::WILL => 0, PropertyCodes::INTELLIGENCE => 1, PropertyCodes::CHARISMA => 0,
                        PropertyCodes::TOUGHNESS => -1,
                        PropertyCodes::HEIGHT_IN_CM => 160.0, PropertyCodes::WEIGHT_IN_KG => 50.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 0, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                RaceCodes::DWARF => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => 1, PropertyCodes::AGILITY => -1, PropertyCodes::KNACK => 0, PropertyCodes::WILL => 2,
                        PropertyCodes::INTELLIGENCE => -1, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 1,
                        PropertyCodes::HEIGHT_IN_CM => 140.0, PropertyCodes::WEIGHT_IN_KG => 70.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => -1, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::WOOD => [
                        PropertyCodes::STRENGTH => 1, PropertyCodes::AGILITY => -1, PropertyCodes::KNACK => 0, PropertyCodes::WILL => 1,
                        PropertyCodes::INTELLIGENCE => -1, PropertyCodes::CHARISMA => -1, PropertyCodes::TOUGHNESS => 1,
                        PropertyCodes::HEIGHT_IN_CM => 140.0, PropertyCodes::WEIGHT_IN_KG => 70.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => -1, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::MOUNTAIN => [
                        PropertyCodes::STRENGTH => 2, PropertyCodes::AGILITY => -1, PropertyCodes::KNACK => 0, PropertyCodes::WILL => 2,
                        PropertyCodes::INTELLIGENCE => -2, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 1,
                        PropertyCodes::HEIGHT_IN_CM => 140.0, PropertyCodes::WEIGHT_IN_KG => 70.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => -1, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RaceCodes::HOBBIT => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => -3, PropertyCodes::AGILITY => 1, PropertyCodes::KNACK => 1, PropertyCodes::WILL => 0,
                        PropertyCodes::INTELLIGENCE => -1, PropertyCodes::CHARISMA => 2, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 110.0, PropertyCodes::WEIGHT_IN_KG => 40.0, PropertyCodes::SIZE => -2,
                        PropertyCodes::SENSES => 0, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::TASTE,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RaceCodes::KROLL => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => 3, PropertyCodes::AGILITY => -2, PropertyCodes::KNACK => -1, PropertyCodes::WILL => 1,
                        PropertyCodes::INTELLIGENCE => -3, PropertyCodes::CHARISMA => -1, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 220.0, PropertyCodes::WEIGHT_IN_KG => 120.0, PropertyCodes::SIZE => 3,
                        PropertyCodes::SENSES => 0, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::HEARING,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => true,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::WILD => [
                        PropertyCodes::STRENGTH => 3, PropertyCodes::AGILITY => -1, PropertyCodes::KNACK => -2, PropertyCodes::WILL => 2,
                        PropertyCodes::INTELLIGENCE => -3, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 220.0, PropertyCodes::WEIGHT_IN_KG => 120.0, PropertyCodes::SIZE => 3,
                        PropertyCodes::SENSES => 0, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::HEARING,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => true,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                RaceCodes::ORC => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => 0, PropertyCodes::AGILITY => 2, PropertyCodes::KNACK => 0, PropertyCodes::WILL => -1,
                        PropertyCodes::INTELLIGENCE => 0, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 160.0, PropertyCodes::WEIGHT_IN_KG => 60.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 1, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SMELL,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                    RaceCodes::SKURUT => [
                        PropertyCodes::STRENGTH => 1, PropertyCodes::AGILITY => 1, PropertyCodes::KNACK => -1, PropertyCodes::WILL => 0,
                        PropertyCodes::INTELLIGENCE => 0, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 180.0, PropertyCodes::WEIGHT_IN_KG => 90.0, PropertyCodes::SIZE => 1,
                        PropertyCodes::SENSES => 1, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SMELL,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                    RaceCodes::GOBLIN => [
                        PropertyCodes::STRENGTH => -1, PropertyCodes::AGILITY => 2, PropertyCodes::KNACK => 1, PropertyCodes::WILL => -2,
                        PropertyCodes::INTELLIGENCE => 0, PropertyCodes::CHARISMA => -1, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 150.0, PropertyCodes::WEIGHT_IN_KG => 55.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 1, PropertyCodes::REMARKABLE_SENSE => PropertyCodes::SMELL,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
            ],
            $racesTable->getIndexedValues()
        );
    }

    /**
     * @test
     * @dataProvider strengthOfRaces
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

    public function strengthOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0, -1],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 1, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, -1, -2],
            [RaceCodes::ELF, RaceCodes::GREEN, -1, -2],
            [RaceCodes::ELF, RaceCodes::DARK, 0, -1],
            [RaceCodes::DWARF, RaceCodes::COMMON, 1, 1],
            [RaceCodes::DWARF, RaceCodes::WOOD, 1, 1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 2, 2],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, -3, -4],
            [RaceCodes::KROLL, RaceCodes::COMMON, 3, 2],
            [RaceCodes::KROLL, RaceCodes::WILD, 3, 2],
            [RaceCodes::ORC, RaceCodes::COMMON, 0, -1],
            [RaceCodes::ORC, RaceCodes::SKURUT, 1, 0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, -1, -2],
        ];
    }

    /**
     * @test
     * @dataProvider agilityOfRaces
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

    public function agilityOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 0, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, 1, 1],
            [RaceCodes::ELF, RaceCodes::GREEN, 1, 1],
            [RaceCodes::ELF, RaceCodes::DARK, 0, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, -1, -1],
            [RaceCodes::DWARF, RaceCodes::WOOD, -1, -1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, -1, -1],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 1, 2],
            [RaceCodes::KROLL, RaceCodes::COMMON, -2, -1],
            [RaceCodes::KROLL, RaceCodes::WILD, -1, 0],
            [RaceCodes::ORC, RaceCodes::COMMON, 2, 2],
            [RaceCodes::ORC, RaceCodes::SKURUT, 1, 1],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 2, 2],
        ];
    }

    /**
     * @test
     * @dataProvider knackOfRaces
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

    public function knackOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 0, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, 1, 2],
            [RaceCodes::ELF, RaceCodes::GREEN, 0, 1],
            [RaceCodes::ELF, RaceCodes::DARK, 0, 1],
            [RaceCodes::DWARF, RaceCodes::COMMON, 0, -1],
            [RaceCodes::DWARF, RaceCodes::WOOD, 0, -1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 0, -1],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 1, 0],
            [RaceCodes::KROLL, RaceCodes::COMMON, -1, -1],
            [RaceCodes::KROLL, RaceCodes::WILD, -2, -2],
            [RaceCodes::ORC, RaceCodes::COMMON, 0, 0],
            [RaceCodes::ORC, RaceCodes::SKURUT, -1, -1],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 1, 1],
        ];
    }

    /**
     * @test
     * @dataProvider willOfRaces
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

    public function willOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 1, 1],
            [RaceCodes::ELF, RaceCodes::COMMON, -2, -2],
            [RaceCodes::ELF, RaceCodes::GREEN, -1, -1],
            [RaceCodes::ELF, RaceCodes::DARK, 0, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, 2, 2],
            [RaceCodes::DWARF, RaceCodes::WOOD, 1, 1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 2, 2],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 0, 0],
            [RaceCodes::KROLL, RaceCodes::COMMON, 1, 0],
            [RaceCodes::KROLL, RaceCodes::WILD, 2, 1],
            [RaceCodes::ORC, RaceCodes::COMMON, -1, 0],
            [RaceCodes::ORC, RaceCodes::SKURUT, 0, 1],
            [RaceCodes::ORC, RaceCodes::GOBLIN, -2, -1],
        ];
    }

    /**
     * @test
     * @dataProvider intelligenceOfRaces
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

    public function intelligenceOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, -1, -1],
            [RaceCodes::ELF, RaceCodes::COMMON, 1, 0],
            [RaceCodes::ELF, RaceCodes::GREEN, 1, 0],
            [RaceCodes::ELF, RaceCodes::DARK, 1, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, -1, 0],
            [RaceCodes::DWARF, RaceCodes::WOOD, -1, 0],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, -2, -1],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, -1, -1],
            [RaceCodes::KROLL, RaceCodes::COMMON, -3, -3],
            [RaceCodes::KROLL, RaceCodes::WILD, -3, -3],
            [RaceCodes::ORC, RaceCodes::COMMON, 0, 0],
            [RaceCodes::ORC, RaceCodes::SKURUT, 0, 0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 0, 0],
        ];
    }

    /**
     * @test
     * @dataProvider charismaOfRaces
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

    public function charismaOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0, 1],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, -1, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, 1, 2],
            [RaceCodes::ELF, RaceCodes::GREEN, 1, 2],
            [RaceCodes::ELF, RaceCodes::DARK, 0, 1],
            [RaceCodes::DWARF, RaceCodes::COMMON, -2, -2],
            [RaceCodes::DWARF, RaceCodes::WOOD, -1, -1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, -2, -2],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 2, 3],
            [RaceCodes::KROLL, RaceCodes::COMMON, -1, 0],
            [RaceCodes::KROLL, RaceCodes::WILD, -2, -1],
            [RaceCodes::ORC, RaceCodes::COMMON, -2, -2],
            [RaceCodes::ORC, RaceCodes::SKURUT, -2, -2],
            [RaceCodes::ORC, RaceCodes::GOBLIN, -1, -1],
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
        self::assertSame($toughness, $racesTable->getToughness($race, $subrace));
    }

    public function toughnessOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, -1],
            [RaceCodes::ELF, RaceCodes::GREEN, -1],
            [RaceCodes::ELF, RaceCodes::DARK, -1],
            [RaceCodes::DWARF, RaceCodes::COMMON, 1],
            [RaceCodes::DWARF, RaceCodes::WOOD, 1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 1],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 0],
            [RaceCodes::KROLL, RaceCodes::COMMON, 0],
            [RaceCodes::KROLL, RaceCodes::WILD, 0],
            [RaceCodes::ORC, RaceCodes::COMMON, 0],
            [RaceCodes::ORC, RaceCodes::SKURUT, 0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 0],
        ];
    }

    /**
     * @test
     * @dataProvider heightOfRaces
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

    public function heightOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 180.0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 180.0],
            [RaceCodes::ELF, RaceCodes::COMMON, 160.0],
            [RaceCodes::ELF, RaceCodes::GREEN, 160.0],
            [RaceCodes::ELF, RaceCodes::DARK, 160.0],
            [RaceCodes::DWARF, RaceCodes::COMMON, 140.0],
            [RaceCodes::DWARF, RaceCodes::WOOD, 140.0],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 140.0],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 110.0],
            [RaceCodes::KROLL, RaceCodes::COMMON, 220.0],
            [RaceCodes::KROLL, RaceCodes::WILD, 220.0],
            [RaceCodes::ORC, RaceCodes::COMMON, 160.0],
            [RaceCodes::ORC, RaceCodes::SKURUT, 180.0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 150.0],
        ];
    }

    /**
     * @test
     * @dataProvider weightOfRaces
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
            $racesTable->getWeightInKg($race, $subrace, GenderCodes::MALE, $femaleModifiersTable, $weightTable)
        );
        self::assertSame(
            $femaleWeightInKg,
            $racesTable->getWeightInKg($race, $subrace, GenderCodes::FEMALE, $femaleModifiersTable, $weightTable)
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
            RaceCodes::HUMAN,
            RaceCodes::COMMON,
            'not from this universe',
            new FemaleModifiersTable(),
            new WeightTable()
        );
    }

    public function weightOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 80.0, 70.0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 80.0, 70.0],
            [RaceCodes::ELF, RaceCodes::COMMON, 50.0, 45.0],
            [RaceCodes::ELF, RaceCodes::GREEN, 50.0, 45.0],
            [RaceCodes::ELF, RaceCodes::DARK, 50.0, 45.0],
            [RaceCodes::DWARF, RaceCodes::COMMON, 70.0, 70.0],
            [RaceCodes::DWARF, RaceCodes::WOOD, 70.0, 70.0],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 70.0, 70.0],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 40.0, 36.0],
            [RaceCodes::KROLL, RaceCodes::COMMON, 120.0, 110.0],
            [RaceCodes::KROLL, RaceCodes::WILD, 120.0, 110.0],
            [RaceCodes::ORC, RaceCodes::COMMON, 60.0, 56.0],
            [RaceCodes::ORC, RaceCodes::SKURUT, 90.0, 80.0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 55.0, 50.0],
        ];
    }

    /**
     * @test
     * @dataProvider sizeOfRaces
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
        self::assertSame($maleSize, $racesTable->getSize($race, $subrace, GenderCodes::MALE, $femaleModifiersTable));

        self::assertSame($femaleSize, $racesTable->getFemaleSize($race, $subrace, $femaleModifiersTable));
        self::assertSame($femaleSize, $racesTable->getSize($race, $subrace, GenderCodes::FEMALE, $femaleModifiersTable));
    }

    public function sizeOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0, -1],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 0, -1],
            [RaceCodes::ELF, RaceCodes::COMMON, -1, -2],
            [RaceCodes::ELF, RaceCodes::GREEN, -1, -2],
            [RaceCodes::ELF, RaceCodes::DARK, -1, -2],
            [RaceCodes::DWARF, RaceCodes::COMMON, 0, 0],
            [RaceCodes::DWARF, RaceCodes::WOOD, 0, 0],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 0, 0],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, -2, -3],
            [RaceCodes::KROLL, RaceCodes::COMMON, 3, 2],
            [RaceCodes::KROLL, RaceCodes::WILD, 3, 2],
            [RaceCodes::ORC, RaceCodes::COMMON, -1, -2],
            [RaceCodes::ORC, RaceCodes::SKURUT, 1, 0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, -1, -2],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Races\Exceptions\UnknownGender
     */
    public function I_can_not_get_size_for_unknown_gender()
    {
        $racesTable = new RacesTable();
        $racesTable->getSize(RaceCodes::HUMAN, RaceCodes::COMMON, 'unknown gender', new FemaleModifiersTable());
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
        self::assertSame($senses, $racesTable->getSenses($race, $subrace));
    }

    public function sensesOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, 0],
            [RaceCodes::ELF, RaceCodes::GREEN, 0],
            [RaceCodes::ELF, RaceCodes::DARK, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, -1],
            [RaceCodes::DWARF, RaceCodes::WOOD, -1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, -1],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 0],
            [RaceCodes::KROLL, RaceCodes::COMMON, 0],
            [RaceCodes::KROLL, RaceCodes::WILD, 0],
            [RaceCodes::ORC, RaceCodes::COMMON, 1],
            [RaceCodes::ORC, RaceCodes::SKURUT, 1],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 1],
        ];
    }

    /**
     * @test
     * @dataProvider remarkableSenseOfRaces
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

    public function remarkableSenseOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, ''],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, ''],
            [RaceCodes::ELF, RaceCodes::COMMON, PropertyCodes::SIGHT],
            [RaceCodes::ELF, RaceCodes::GREEN, PropertyCodes::SIGHT],
            [RaceCodes::ELF, RaceCodes::DARK, PropertyCodes::SIGHT],
            [RaceCodes::DWARF, RaceCodes::COMMON, PropertyCodes::TOUCH],
            [RaceCodes::DWARF, RaceCodes::WOOD, PropertyCodes::TOUCH],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, PropertyCodes::TOUCH],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, PropertyCodes::TASTE],
            [RaceCodes::KROLL, RaceCodes::COMMON, PropertyCodes::HEARING],
            [RaceCodes::KROLL, RaceCodes::WILD, PropertyCodes::HEARING],
            [RaceCodes::ORC, RaceCodes::COMMON, PropertyCodes::SMELL],
            [RaceCodes::ORC, RaceCodes::SKURUT, PropertyCodes::SMELL],
            [RaceCodes::ORC, RaceCodes::GOBLIN, PropertyCodes::SMELL],
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
        self::assertSame($infravision, $racesTable->hasInfravision($race, $subrace));
    }

    public function infravisionOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, false],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, false],
            [RaceCodes::ELF, RaceCodes::COMMON, false],
            [RaceCodes::ELF, RaceCodes::GREEN, false],
            [RaceCodes::ELF, RaceCodes::DARK, true],
            [RaceCodes::DWARF, RaceCodes::COMMON, true],
            [RaceCodes::DWARF, RaceCodes::WOOD, true],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, true],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, false],
            [RaceCodes::KROLL, RaceCodes::COMMON, false],
            [RaceCodes::KROLL, RaceCodes::WILD, false],
            [RaceCodes::ORC, RaceCodes::COMMON, true],
            [RaceCodes::ORC, RaceCodes::SKURUT, true],
            [RaceCodes::ORC, RaceCodes::GOBLIN, true],
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
        self::assertSame($nativeRegeneration, $racesTable->hasNativeRegeneration($race, $subrace));
    }

    public function nativeRegenerationOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, false],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, false],
            [RaceCodes::ELF, RaceCodes::COMMON, false],
            [RaceCodes::ELF, RaceCodes::GREEN, false],
            [RaceCodes::ELF, RaceCodes::DARK, false],
            [RaceCodes::DWARF, RaceCodes::COMMON, false],
            [RaceCodes::DWARF, RaceCodes::WOOD, false],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, false],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, false],
            [RaceCodes::KROLL, RaceCodes::COMMON, true],
            [RaceCodes::KROLL, RaceCodes::WILD, true],
            [RaceCodes::ORC, RaceCodes::COMMON, false],
            [RaceCodes::ORC, RaceCodes::SKURUT, false],
            [RaceCodes::ORC, RaceCodes::GOBLIN, false],
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
        self::assertSame($requiredDmAgreement, $racesTable->requiresDmAgreement($race, $subrace));
    }

    public function requirementOfDmOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, false],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, false],
            [RaceCodes::ELF, RaceCodes::COMMON, false],
            [RaceCodes::ELF, RaceCodes::GREEN, false],
            [RaceCodes::ELF, RaceCodes::DARK, true],
            [RaceCodes::DWARF, RaceCodes::COMMON, false],
            [RaceCodes::DWARF, RaceCodes::WOOD, false],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, false],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, false],
            [RaceCodes::KROLL, RaceCodes::COMMON, false],
            [RaceCodes::KROLL, RaceCodes::WILD, true],
            [RaceCodes::ORC, RaceCodes::COMMON, true],
            [RaceCodes::ORC, RaceCodes::SKURUT, true],
            [RaceCodes::ORC, RaceCodes::GOBLIN, true],
        ];
    }
}
