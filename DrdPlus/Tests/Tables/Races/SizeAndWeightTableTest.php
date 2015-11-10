<?php
namespace DrdPlus\Tables\Races;

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

}
