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

class SizeAndWeightTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_get_human_modifiers()
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertEquals(
            $sizeAndWeightTable->getCommonHumanModifiers(),
            $sizeAndWeightTable->getHighlanderModifiers()
        );
        $this->assertEquals(
            [
                SizeAndWeightTable::HEIGHT_IN_CM => 180,
                SizeAndWeightTable::WEIGHT_IN_KG => 80,
                SizeAndWeightTable::SIZE => 0,
            ],
            $sizeAndWeightTable->getCommonHumanModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_dwarf_modifiers()
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertEquals(
            $sizeAndWeightTable->getCommonDwarfModifier(),
            $sizeAndWeightTable->getWoodDwarfModifier(),
            $sizeAndWeightTable->getMountainDwarfModifier()
        );
        $this->assertEquals(
            [
                SizeAndWeightTable::HEIGHT_IN_CM => 140,
                SizeAndWeightTable::WEIGHT_IN_KG => 70,
                SizeAndWeightTable::SIZE => 0,
            ],
            $sizeAndWeightTable->getCommonDwarfModifier()
        );
    }

    /**
     * @test
     */
    public function I_can_get_elf_modifiers()
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertEquals(
            $sizeAndWeightTable->getCommonElfModifiers(),
            $sizeAndWeightTable->getGreenElfModifiers(),
            $sizeAndWeightTable->getDarkElfModifiers()
        );
        $this->assertEquals(
            [
                SizeAndWeightTable::HEIGHT_IN_CM => 160,
                SizeAndWeightTable::WEIGHT_IN_KG => 50,
                SizeAndWeightTable::SIZE => -1,
            ],
            $sizeAndWeightTable->getCommonElfModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_hobbit_modifiers()
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertEquals(
            [
                SizeAndWeightTable::HEIGHT_IN_CM => 110,
                SizeAndWeightTable::WEIGHT_IN_KG => 40,
                SizeAndWeightTable::SIZE => -2,
            ],
            $sizeAndWeightTable->getCommonHobbitModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_kroll_modifiers()
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertEquals(
            $sizeAndWeightTable->getCommonKrollModifier(),
            $sizeAndWeightTable->getWildKrollModifier()
        );
        $this->assertEquals(
            [
                SizeAndWeightTable::HEIGHT_IN_CM => 220,
                SizeAndWeightTable::WEIGHT_IN_KG => 120,
                SizeAndWeightTable::SIZE => 3,
            ],
            $sizeAndWeightTable->getCommonKrollModifier()
        );
    }

    /**
     * @test
     */
    public function I_can_get_common_orc_modifiers()
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertEquals(
            [
                SizeAndWeightTable::HEIGHT_IN_CM => 160,
                SizeAndWeightTable::WEIGHT_IN_KG => 60,
                SizeAndWeightTable::SIZE => -1,
            ],
            $sizeAndWeightTable->getCommonOrcModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_goblin_modifiers()
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertEquals(
            [
                SizeAndWeightTable::HEIGHT_IN_CM => 150,
                SizeAndWeightTable::WEIGHT_IN_KG => 55,
                SizeAndWeightTable::SIZE => -1,
            ],
            $sizeAndWeightTable->getGoblinModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_skurut_modifiers()
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertEquals(
            [
                SizeAndWeightTable::HEIGHT_IN_CM => 180,
                SizeAndWeightTable::WEIGHT_IN_KG => 90,
                SizeAndWeightTable::SIZE => 1,
            ],
            $sizeAndWeightTable->getSkurutModifiers()
        );
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param int $size
     *
     * @test
     * @dataProvider sizeOfRaces
     */
    public function I_can_get_size_for_any_race($raceCode, $subraceCode, $size)
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertSame(
            $sizeAndWeightTable->getSize($raceCode, $subraceCode),
            $size
        );
    }

    public function sizeOfRaces()
    {
        return [
            [Human::HUMAN, CommonHuman::COMMON, 0],
            [Human::HUMAN, Highlander::HIGHLANDER, 0],
            [Dwarf::DWARF, CommonDwarf::COMMON, 0],
            [Dwarf::DWARF, WoodDwarf::WOOD, 0],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, 0],
            [Elf::ELF, CommonElf::COMMON, -1],
            [Elf::ELF, GreenElf::GREEN, -1],
            [Elf::ELF, DarkElf::DARK, -1],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, -2],
            [Kroll::KROLL, CommonKroll::COMMON, 3],
            [Kroll::KROLL, WildKroll::WILD, 3],
            [Orc::ORC, CommonOrc::COMMON, -1],
            [Orc::ORC, Skurut::SKURUT, 1],
            [Orc::ORC, Goblin::GOBLIN, -1],
        ];
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param int $weight
     *
     * @test
     * @dataProvider weightOfRaces
     */
    public function I_can_get_weight_for_any_race($raceCode, $subraceCode, $weight)
    {
        $sizeAndWeightTable = new SizeAndWeightTable();
        $this->assertSame(
            $sizeAndWeightTable->getWeight($raceCode, $subraceCode),
            $weight
        );
    }

    public function weightOfRaces()
    {
        return [
            [Human::HUMAN, CommonHuman::COMMON, 80.0],
            [Human::HUMAN, Highlander::HIGHLANDER, 80.0],
            [Dwarf::DWARF, CommonDwarf::COMMON, 70.0],
            [Dwarf::DWARF, WoodDwarf::WOOD, 70.0],
            [Dwarf::DWARF, MountainDwarf::MOUNTAIN, 70.0],
            [Elf::ELF, CommonElf::COMMON, 50.0],
            [Elf::ELF, GreenElf::GREEN, 50.0],
            [Elf::ELF, DarkElf::DARK, 50.0],
            [Hobbit::HOBBIT, CommonHobbit::COMMON, 40.0],
            [Kroll::KROLL, CommonKroll::COMMON, 120.0],
            [Kroll::KROLL, WildKroll::WILD, 120.0],
            [Orc::ORC, CommonOrc::COMMON, 60.0],
            [Orc::ORC, Skurut::SKURUT, 90.0],
            [Orc::ORC, Goblin::GOBLIN, 55.0],
        ];
    }

}
