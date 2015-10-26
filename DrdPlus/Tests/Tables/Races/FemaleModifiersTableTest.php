<?php
namespace DrdPlus\Tables\Races;

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
                RacesTable::STRENGTH => -1,
                RacesTable::AGILITY => 0,
                RacesTable::KNACK => 0,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => 0,
                RacesTable::CHARISMA => +1,
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
                RacesTable::STRENGTH => -1,
                RacesTable::AGILITY => 0,
                RacesTable::KNACK => +1,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => -1,
                RacesTable::CHARISMA => +1,
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
                RacesTable::STRENGTH => 0,
                RacesTable::AGILITY => 0,
                RacesTable::KNACK => -1,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => +1,
                RacesTable::CHARISMA => 0,
            ],
            $this->getFemaleModifiersTable()->getDwarfModifiers()
        );
    }
}
