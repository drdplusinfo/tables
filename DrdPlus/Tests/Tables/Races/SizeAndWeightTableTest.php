<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Properties\Body\HeightInCm;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Properties\Body\WeightInKg;
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
                SizeAndWeightTable::HEIGHT_IN_CM => HeightInCm::getIt(180),
                SizeAndWeightTable::WEIGHT_IN_KG => WeightInKg::getIt(80),
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
                SizeAndWeightTable::HEIGHT_IN_CM => HeightInCm::getIt(140),
                SizeAndWeightTable::WEIGHT_IN_KG => WeightInKg::getIt(70),
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
                SizeAndWeightTable::HEIGHT_IN_CM => HeightInCm::getIt(160),
                SizeAndWeightTable::WEIGHT_IN_KG => WeightInKg::getIt(50),
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
                SizeAndWeightTable::HEIGHT_IN_CM => HeightInCm::getIt(110),
                SizeAndWeightTable::WEIGHT_IN_KG => WeightInKg::getIt(40),
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
                SizeAndWeightTable::HEIGHT_IN_CM => HeightInCm::getIt(220),
                SizeAndWeightTable::WEIGHT_IN_KG => WeightInKg::getIt(120),
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
                SizeAndWeightTable::HEIGHT_IN_CM => HeightInCm::getIt(160),
                SizeAndWeightTable::WEIGHT_IN_KG => WeightInKg::getIt(60),
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
                SizeAndWeightTable::HEIGHT_IN_CM => HeightInCm::getIt(150),
                SizeAndWeightTable::WEIGHT_IN_KG => WeightInKg::getIt(55),
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
                SizeAndWeightTable::HEIGHT_IN_CM => HeightInCm::getIt(180),
                SizeAndWeightTable::WEIGHT_IN_KG => WeightInKg::getIt(90),
                SizeAndWeightTable::SIZE => new Size(1),
            ],
            $sizeAndWeightTable->getSkurutModifiers()
        );
    }

}
