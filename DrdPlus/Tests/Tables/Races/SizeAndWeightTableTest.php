<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Properties\Body\Size;
use DrdPlus\Tests\Races\TestWithMockery;

class SizeAndWeightTableTest extends TestWithMockery
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
                SizeAndWeightTable::HEIGHT => 180,
                SizeAndWeightTable::WEIGHT => 80,
                SizeAndWeightTable::SIZE => new Size(0),
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
                SizeAndWeightTable::HEIGHT => 140,
                SizeAndWeightTable::WEIGHT => 70,
                SizeAndWeightTable::SIZE => new Size(0),
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
                SizeAndWeightTable::HEIGHT => 160,
                SizeAndWeightTable::WEIGHT => 50,
                SizeAndWeightTable::SIZE => new Size(-1),
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
                SizeAndWeightTable::HEIGHT => 110,
                SizeAndWeightTable::WEIGHT => 40,
                SizeAndWeightTable::SIZE => new Size(-2),
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
                SizeAndWeightTable::HEIGHT => 220,
                SizeAndWeightTable::WEIGHT => 120,
                SizeAndWeightTable::SIZE => new Size(3),
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
                SizeAndWeightTable::HEIGHT => 160,
                SizeAndWeightTable::WEIGHT => 60,
                SizeAndWeightTable::SIZE => new Size(-1),
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
                SizeAndWeightTable::HEIGHT => 150,
                SizeAndWeightTable::WEIGHT => 55,
                SizeAndWeightTable::SIZE => new Size(-1),
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
                SizeAndWeightTable::HEIGHT => 180,
                SizeAndWeightTable::WEIGHT => 90,
                SizeAndWeightTable::SIZE => new Size(1),
            ],
            $sizeAndWeightTable->getSkurutModifiers()
        );
    }

}
