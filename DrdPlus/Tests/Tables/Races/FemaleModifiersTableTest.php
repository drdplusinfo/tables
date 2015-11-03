<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Tools\Tests\TestWithMockery;

class FemaleModifiersTableTest extends TestWithMockery
{
    private static $femaleModifiersTable;

    protected function getFemaleModifiersTable()
    {
        if (!isset(self::$femaleModifiersTable)) {
            self::$femaleModifiersTable = new FemaleModifiersTable();
        }

        return self::$femaleModifiersTable;
    }

    /**
     * @test
     */
    public function I_can_get_human_female_modifiers()
    {
        $this->assertEquals(
            [
                RacesTable::STRENGTH => new Strength(-1),
                RacesTable::AGILITY => new Agility(0),
                RacesTable::KNACK => new Knack(0),
                RacesTable::WILL => new Will(0),
                RacesTable::INTELLIGENCE => new Intelligence(0),
                RacesTable::CHARISMA => new Charisma(+1),
            ],
            $this->getFemaleModifiersTable()->getHumanModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_elf_female_modifiers()
    {
        $this->assertEquals(
            [
                RacesTable::STRENGTH => new Strength(-1),
                RacesTable::AGILITY => new Agility(0),
                RacesTable::KNACK => new Knack(+1),
                RacesTable::WILL => new Will(0),
                RacesTable::INTELLIGENCE => new Intelligence(-1),
                RacesTable::CHARISMA => new Charisma(+1),
            ],
            $this->getFemaleModifiersTable()->getElfModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_dwarf_female_modifiers()
    {
        $this->assertEquals(
            [
                RacesTable::STRENGTH => new Strength(0),
                RacesTable::AGILITY => new Agility(0),
                RacesTable::KNACK => new Knack(-1),
                RacesTable::WILL => new Will(0),
                RacesTable::INTELLIGENCE => new Intelligence(+1),
                RacesTable::CHARISMA => new Charisma(0),
            ],
            $this->getFemaleModifiersTable()->getDwarfModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_hobbit_female_modifiers()
    {
        $this->assertEquals(
            [
                RacesTable::STRENGTH => new Strength(-1),
                RacesTable::AGILITY => new Agility(1),
                RacesTable::KNACK => new Knack(-1),
                RacesTable::WILL => new Will(0),
                RacesTable::INTELLIGENCE => new Intelligence(0),
                RacesTable::CHARISMA => new Charisma(1),
            ],
            $this->getFemaleModifiersTable()->getHobbitModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_kroll_female_modifiers()
    {
        $this->assertEquals(
            [
                RacesTable::STRENGTH => new Strength(-1),
                RacesTable::AGILITY => new Agility(1),
                RacesTable::KNACK => new Knack(0),
                RacesTable::WILL => new Will(-1),
                RacesTable::INTELLIGENCE => new Intelligence(0),
                RacesTable::CHARISMA => new Charisma(1),
            ],
            $this->getFemaleModifiersTable()->getKrollModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_orc_female_modifiers()
    {
        $this->assertEquals(
            [
                RacesTable::STRENGTH => new Strength(-1),
                RacesTable::AGILITY => new Agility(0),
                RacesTable::KNACK => new Knack(0),
                RacesTable::WILL => new Will(1),
                RacesTable::INTELLIGENCE => new Intelligence(0),
                RacesTable::CHARISMA => new Charisma(0),
            ],
            $this->getFemaleModifiersTable()->getOrcModifiers()
        );
    }
}
