<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Races\Dwarfs\Dwarf;
use DrdPlus\Races\Elfs\Elf;
use DrdPlus\Races\Hobbits\Hobbit;
use DrdPlus\Races\Humans\Human;
use DrdPlus\Races\Krolls\Kroll;
use DrdPlus\Races\Orcs\Orc;

class FemaleModifiersTableTest extends \PHPUnit_Framework_TestCase
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
                RacesTable::CHARISMA => 1,
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
                RacesTable::KNACK => 1,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => -1,
                RacesTable::CHARISMA => 1,
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
                RacesTable::INTELLIGENCE => 1,
                RacesTable::CHARISMA => 0,
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
                RacesTable::STRENGTH => -1,
                RacesTable::AGILITY => 1,
                RacesTable::KNACK => -1,
                RacesTable::WILL => 0,
                RacesTable::INTELLIGENCE => 0,
                RacesTable::CHARISMA => 1,
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
                RacesTable::STRENGTH => -1,
                RacesTable::AGILITY => 1,
                RacesTable::KNACK => 0,
                RacesTable::WILL => -1,
                RacesTable::INTELLIGENCE => 0,
                RacesTable::CHARISMA => 1,
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
                RacesTable::STRENGTH => -1,
                RacesTable::AGILITY => 0,
                RacesTable::KNACK => 0,
                RacesTable::WILL => 1,
                RacesTable::INTELLIGENCE => 0,
                RacesTable::CHARISMA => 0,
            ],
            $this->getFemaleModifiersTable()->getOrcModifiers()
        );
    }

    /**
     * @test
     */
    public function I_got_expected_values()
    {
        $this->assertEquals(
            [
                Human::HUMAN => [
                    RacesTable::STRENGTH => -1, RacesTable::AGILITY => 0, RacesTable::KNACK => 0,
                    RacesTable::WILL => 0, RacesTable::INTELLIGENCE => 0, RacesTable::CHARISMA => 1,
                ],
                Elf::ELF => [
                    RacesTable::STRENGTH => -1,
                    RacesTable::AGILITY => 0,
                    RacesTable::KNACK => 1,
                    RacesTable::WILL => 0,
                    RacesTable::INTELLIGENCE => -1,
                    RacesTable::CHARISMA => 1,
                ],
                Dwarf::DWARF => [
                    RacesTable::STRENGTH => 0,
                    RacesTable::AGILITY => 0,
                    RacesTable::KNACK => -1,
                    RacesTable::WILL => 0,
                    RacesTable::INTELLIGENCE => 1,
                    RacesTable::CHARISMA => 0,
                ],
                Hobbit::HOBBIT => [
                    RacesTable::STRENGTH => -1,
                    RacesTable::AGILITY => 1,
                    RacesTable::KNACK => -1,
                    RacesTable::WILL => 0,
                    RacesTable::INTELLIGENCE => 0,
                    RacesTable::CHARISMA => 1,
                ],
                Kroll::KROLL => [
                    RacesTable::STRENGTH => -1,
                    RacesTable::AGILITY => 1,
                    RacesTable::KNACK => 0,
                    RacesTable::WILL => -1,
                    RacesTable::INTELLIGENCE => 0,
                    RacesTable::CHARISMA => 1,
                ],
                Orc::ORC => [
                    RacesTable::STRENGTH => -1,
                    RacesTable::AGILITY => 0,
                    RacesTable::KNACK => 0,
                    RacesTable::WILL => 1,
                    RacesTable::INTELLIGENCE => 0,
                    RacesTable::CHARISMA => 0,
                ],
            ],
            $this->getFemaleModifiersTable()->getValues()
        );
    }
}
