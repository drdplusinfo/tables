<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\PropertyCodes;
use DrdPlus\Codes\RaceCodes;

class RacesTableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function I_can_get_common_human_modifiers()
    {
        $racesTable = new RacesTable();
        $modifiers = $racesTable->getCommonHumanModifiers();
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => '',
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => '',
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::TOUCH,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::TOUCH,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::TOUCH,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::SIGHT,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::SIGHT,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::SIGHT,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::TASTE,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::HEARING,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::HEARING,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::SMELL,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::SMELL,
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
        $this->assertEquals(
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
                RacesTable::REMARKABLE_SENSE => PropertyCodes::SMELL,
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
        $this->assertSame(
            [
                RaceCodes::HUMAN => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => 0, PropertyCodes::AGILITY => 0, PropertyCodes::KNACK => 0, PropertyCodes::WILL => 0,
                        PropertyCodes::INTELLIGENCE => 0, PropertyCodes::CHARISMA => 0, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 180.0, PropertyCodes::WEIGHT_IN_KG => 80.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => 0, RacesTable::REMARKABLE_SENSE => '',
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::HIGHLANDER => [PropertyCodes::STRENGTH => 1, PropertyCodes::AGILITY => 0, PropertyCodes::KNACK => 0,
                        PropertyCodes::WILL => 1, PropertyCodes::INTELLIGENCE => -1, PropertyCodes::CHARISMA => -1,
                        PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 180.0, PropertyCodes::WEIGHT_IN_KG => 80.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => 0, RacesTable::REMARKABLE_SENSE => '',
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
                        PropertyCodes::SENSES => 0, RacesTable::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::GREEN => [
                        PropertyCodes::STRENGTH => -1, PropertyCodes::AGILITY => 1, PropertyCodes::KNACK => 0,
                        PropertyCodes::WILL => -1, PropertyCodes::INTELLIGENCE => 1, PropertyCodes::CHARISMA => 1,
                        PropertyCodes::TOUGHNESS => -1,
                        PropertyCodes::HEIGHT_IN_CM => 160.0, PropertyCodes::WEIGHT_IN_KG => 50.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 0, RacesTable::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::DARK => [
                        PropertyCodes::STRENGTH => 0, PropertyCodes::AGILITY => 0, PropertyCodes::KNACK => 0,
                        PropertyCodes::WILL => 0, PropertyCodes::INTELLIGENCE => 1, PropertyCodes::CHARISMA => 0,
                        PropertyCodes::TOUGHNESS => -1,
                        PropertyCodes::HEIGHT_IN_CM => 160.0, PropertyCodes::WEIGHT_IN_KG => 50.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 0, RacesTable::REMARKABLE_SENSE => PropertyCodes::SIGHT,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                RaceCodes::DWARF => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => 1, PropertyCodes::AGILITY => -1, PropertyCodes::KNACK => 0, PropertyCodes::WILL => 2,
                        PropertyCodes::INTELLIGENCE => -1, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 1,
                        PropertyCodes::HEIGHT_IN_CM => 140.0, PropertyCodes::WEIGHT_IN_KG => 70.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => -1, RacesTable::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::WOOD => [
                        PropertyCodes::STRENGTH => 1, PropertyCodes::AGILITY => -1, PropertyCodes::KNACK => 0, PropertyCodes::WILL => 1,
                        PropertyCodes::INTELLIGENCE => -1, PropertyCodes::CHARISMA => -1, PropertyCodes::TOUGHNESS => 1,
                        PropertyCodes::HEIGHT_IN_CM => 140.0, PropertyCodes::WEIGHT_IN_KG => 70.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => -1, RacesTable::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::MOUNTAIN => [
                        PropertyCodes::STRENGTH => 2, PropertyCodes::AGILITY => -1, PropertyCodes::KNACK => 0, PropertyCodes::WILL => 2,
                        PropertyCodes::INTELLIGENCE => -2, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 1,
                        PropertyCodes::HEIGHT_IN_CM => 140.0, PropertyCodes::WEIGHT_IN_KG => 70.0, PropertyCodes::SIZE => 0,
                        PropertyCodes::SENSES => -1, RacesTable::REMARKABLE_SENSE => PropertyCodes::TOUCH,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RaceCodes::HOBBIT => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => -3, PropertyCodes::AGILITY => 1, PropertyCodes::KNACK => 1, PropertyCodes::WILL => 0,
                        PropertyCodes::INTELLIGENCE => -1, PropertyCodes::CHARISMA => 2, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 110.0, PropertyCodes::WEIGHT_IN_KG => 40.0, PropertyCodes::SIZE => -2,
                        PropertyCodes::SENSES => 0, RacesTable::REMARKABLE_SENSE => PropertyCodes::TASTE,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                ],
                RaceCodes::KROLL => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => 3, PropertyCodes::AGILITY => -2, PropertyCodes::KNACK => -1, PropertyCodes::WILL => 1,
                        PropertyCodes::INTELLIGENCE => -3, PropertyCodes::CHARISMA => -1, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 220.0, PropertyCodes::WEIGHT_IN_KG => 120.0, PropertyCodes::SIZE => 3,
                        PropertyCodes::SENSES => 0, RacesTable::REMARKABLE_SENSE => PropertyCodes::HEARING,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => true,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => false
                    ],
                    RaceCodes::WILD => [
                        PropertyCodes::STRENGTH => 3, PropertyCodes::AGILITY => -1, PropertyCodes::KNACK => -2, PropertyCodes::WILL => 2,
                        PropertyCodes::INTELLIGENCE => -3, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 220.0, PropertyCodes::WEIGHT_IN_KG => 120.0, PropertyCodes::SIZE => 3,
                        PropertyCodes::SENSES => 0, RacesTable::REMARKABLE_SENSE => PropertyCodes::HEARING,
                        PropertyCodes::INFRAVISION => false, PropertyCodes::NATIVE_REGENERATION => true,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                ],
                RaceCodes::ORC => [
                    RaceCodes::COMMON => [
                        PropertyCodes::STRENGTH => 0, PropertyCodes::AGILITY => 2, PropertyCodes::KNACK => 0, PropertyCodes::WILL => -1,
                        PropertyCodes::INTELLIGENCE => 0, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 160.0, PropertyCodes::WEIGHT_IN_KG => 60.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 1, RacesTable::REMARKABLE_SENSE => PropertyCodes::SMELL,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                    RaceCodes::SKURUT => [
                        PropertyCodes::STRENGTH => 1, PropertyCodes::AGILITY => 1, PropertyCodes::KNACK => -1, PropertyCodes::WILL => 0,
                        PropertyCodes::INTELLIGENCE => 0, PropertyCodes::CHARISMA => -2, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 180.0, PropertyCodes::WEIGHT_IN_KG => 90.0, PropertyCodes::SIZE => 1,
                        PropertyCodes::SENSES => 1, RacesTable::REMARKABLE_SENSE => PropertyCodes::SMELL,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
                    ],
                    RaceCodes::GOBLIN => [
                        PropertyCodes::STRENGTH => -1, PropertyCodes::AGILITY => 2, PropertyCodes::KNACK => 1, PropertyCodes::WILL => -2,
                        PropertyCodes::INTELLIGENCE => 0, PropertyCodes::CHARISMA => -1, PropertyCodes::TOUGHNESS => 0,
                        PropertyCodes::HEIGHT_IN_CM => 150.0, PropertyCodes::WEIGHT_IN_KG => 55.0, PropertyCodes::SIZE => -1,
                        PropertyCodes::SENSES => 1, RacesTable::REMARKABLE_SENSE => PropertyCodes::SMELL,
                        PropertyCodes::INFRAVISION => true, PropertyCodes::NATIVE_REGENERATION => false,
                        PropertyCodes::REQUIRES_DM_AGREEMENT => true
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
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 1],
            [RaceCodes::ELF, RaceCodes::COMMON, -1],
            [RaceCodes::ELF, RaceCodes::GREEN, -1],
            [RaceCodes::ELF, RaceCodes::DARK, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, 1],
            [RaceCodes::DWARF, RaceCodes::WOOD, 1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 2],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, -3],
            [RaceCodes::KROLL, RaceCodes::COMMON, 3],
            [RaceCodes::KROLL, RaceCodes::WILD, 3],
            [RaceCodes::ORC, RaceCodes::COMMON, 0],
            [RaceCodes::ORC, RaceCodes::SKURUT, 1],
            [RaceCodes::ORC, RaceCodes::GOBLIN, -1],
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
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, 1],
            [RaceCodes::ELF, RaceCodes::GREEN, 1],
            [RaceCodes::ELF, RaceCodes::DARK, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, -1],
            [RaceCodes::DWARF, RaceCodes::WOOD, -1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, -1],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 1],
            [RaceCodes::KROLL, RaceCodes::COMMON, -2],
            [RaceCodes::KROLL, RaceCodes::WILD, -1],
            [RaceCodes::ORC, RaceCodes::COMMON, 2],
            [RaceCodes::ORC, RaceCodes::SKURUT, 1],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 2],
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
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, 1],
            [RaceCodes::ELF, RaceCodes::GREEN, 0],
            [RaceCodes::ELF, RaceCodes::DARK, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, 0],
            [RaceCodes::DWARF, RaceCodes::WOOD, 0],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 0],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 1],
            [RaceCodes::KROLL, RaceCodes::COMMON, -1],
            [RaceCodes::KROLL, RaceCodes::WILD, -2],
            [RaceCodes::ORC, RaceCodes::COMMON, 0],
            [RaceCodes::ORC, RaceCodes::SKURUT, -1],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 1],
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
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 1],
            [RaceCodes::ELF, RaceCodes::COMMON, -2],
            [RaceCodes::ELF, RaceCodes::GREEN, -1],
            [RaceCodes::ELF, RaceCodes::DARK, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, 2],
            [RaceCodes::DWARF, RaceCodes::WOOD, 1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 2],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 0],
            [RaceCodes::KROLL, RaceCodes::COMMON, 1],
            [RaceCodes::KROLL, RaceCodes::WILD, 2],
            [RaceCodes::ORC, RaceCodes::COMMON, -1],
            [RaceCodes::ORC, RaceCodes::SKURUT, 0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, -2],
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
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, -1],
            [RaceCodes::ELF, RaceCodes::COMMON, 1],
            [RaceCodes::ELF, RaceCodes::GREEN, 1],
            [RaceCodes::ELF, RaceCodes::DARK, 1],
            [RaceCodes::DWARF, RaceCodes::COMMON, -1],
            [RaceCodes::DWARF, RaceCodes::WOOD, -1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, -2],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, -1],
            [RaceCodes::KROLL, RaceCodes::COMMON, -3],
            [RaceCodes::KROLL, RaceCodes::WILD, -3],
            [RaceCodes::ORC, RaceCodes::COMMON, 0],
            [RaceCodes::ORC, RaceCodes::SKURUT, 0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 0],
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
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, -1],
            [RaceCodes::ELF, RaceCodes::COMMON, 1],
            [RaceCodes::ELF, RaceCodes::GREEN, 1],
            [RaceCodes::ELF, RaceCodes::DARK, 0],
            [RaceCodes::DWARF, RaceCodes::COMMON, -2],
            [RaceCodes::DWARF, RaceCodes::WOOD, -1],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, -2],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 2],
            [RaceCodes::KROLL, RaceCodes::COMMON, -1],
            [RaceCodes::KROLL, RaceCodes::WILD, -2],
            [RaceCodes::ORC, RaceCodes::COMMON, -2],
            [RaceCodes::ORC, RaceCodes::SKURUT, -2],
            [RaceCodes::ORC, RaceCodes::GOBLIN, -1],
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
        $this->assertSame($heightInCm, $racesTable->getHeightInCm($race, $subrace));
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
     * @param int $weightInKg
     */
    public function I_can_get_weight_of_any_race($race, $subrace, $weightInKg)
    {
        $racesTable = new RacesTable();
        $this->assertSame($weightInKg, $racesTable->getWeightInKg($race, $subrace));
    }

    public function weightOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 80.0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 80.0],
            [RaceCodes::ELF, RaceCodes::COMMON, 50.0],
            [RaceCodes::ELF, RaceCodes::GREEN, 50.0],
            [RaceCodes::ELF, RaceCodes::DARK, 50.0],
            [RaceCodes::DWARF, RaceCodes::COMMON, 70.0],
            [RaceCodes::DWARF, RaceCodes::WOOD, 70.0],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 70.0],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, 40.0],
            [RaceCodes::KROLL, RaceCodes::COMMON, 120.0],
            [RaceCodes::KROLL, RaceCodes::WILD, 120.0],
            [RaceCodes::ORC, RaceCodes::COMMON, 60.0],
            [RaceCodes::ORC, RaceCodes::SKURUT, 90.0],
            [RaceCodes::ORC, RaceCodes::GOBLIN, 55.0],
        ];
    }

    /**
     * @test
     * @dataProvider sizeOfRaces
     *
     * @param string $race
     * @param string $subrace
     * @param int $size
     */
    public function I_can_get_size_of_any_race($race, $subrace, $size)
    {
        $racesTable = new RacesTable();
        $this->assertSame($size, $racesTable->getSize($race, $subrace));
    }

    public function sizeOfRaces()
    {
        return [
            [RaceCodes::HUMAN, RaceCodes::COMMON, 0],
            [RaceCodes::HUMAN, RaceCodes::HIGHLANDER, 0],
            [RaceCodes::ELF, RaceCodes::COMMON, -1],
            [RaceCodes::ELF, RaceCodes::GREEN, -1],
            [RaceCodes::ELF, RaceCodes::DARK, -1],
            [RaceCodes::DWARF, RaceCodes::COMMON, 0],
            [RaceCodes::DWARF, RaceCodes::WOOD, 0],
            [RaceCodes::DWARF, RaceCodes::MOUNTAIN, 0],
            [RaceCodes::HOBBIT, RaceCodes::COMMON, -2],
            [RaceCodes::KROLL, RaceCodes::COMMON, 3],
            [RaceCodes::KROLL, RaceCodes::WILD, 3],
            [RaceCodes::ORC, RaceCodes::COMMON, -1],
            [RaceCodes::ORC, RaceCodes::SKURUT, 1],
            [RaceCodes::ORC, RaceCodes::GOBLIN, -1],
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
        $this->assertSame($remarkableSense, $racesTable->getRemarkableSense($race, $subrace));
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
        $this->assertSame($infravision, $racesTable->hasInfravision($race, $subrace));
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
        $this->assertSame($nativeRegeneration, $racesTable->hasNativeRegeneration($race, $subrace));
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
        $this->assertSame($requiredDmAgreement, $racesTable->requiresDmAgreement($race, $subrace));
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
