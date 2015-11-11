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

    /**
     * @test
     * @dataProvider raceToStrength
     *
     * @param string $raceCode
     * @param int $strength
     */
    public function I_can_get_female_strength_of_any_race($raceCode, $strength)
    {
        $table = new FemaleModifiersTable();

        $this->assertSame($strength, $table->getStrength($raceCode));
    }

    public function raceToStrength()
    {
        return [
            [Human::HUMAN, -1],
            [Elf::ELF, -1],
            [Dwarf::DWARF, 0],
            [Hobbit::HOBBIT, -1],
            [Kroll::KROLL, -1],
            [Orc::ORC, -1],
        ];
    }

    /**
     * @test
     * @dataProvider raceToAgility
     *
     * @param string $raceCode
     * @param int $agility
     */
    public function I_can_get_female_agility_of_any_race($raceCode, $agility)
    {
        $table = new FemaleModifiersTable();

        $this->assertSame($agility, $table->getAgility($raceCode));
    }


    public function raceToAgility()
    {
        return [
            [Human::HUMAN, 0],
            [Elf::ELF, 0],
            [Dwarf::DWARF, 0],
            [Hobbit::HOBBIT, 1],
            [Kroll::KROLL, 1],
            [Orc::ORC, 0],
        ];
    }
    
    /**
     * @test
     * @dataProvider raceToKnack
     *
     * @param string $raceCode
     * @param int $knack
     */
    public function I_can_get_female_knack_of_any_race($raceCode, $knack)
    {
        $table = new FemaleModifiersTable();

        $this->assertSame($knack, $table->getKnack($raceCode));
    }


    public function raceToKnack()
    {
        return [
            [Human::HUMAN, 0],
            [Elf::ELF, 1],
            [Dwarf::DWARF, -1],
            [Hobbit::HOBBIT, -1],
            [Kroll::KROLL, 0],
            [Orc::ORC, 0],
        ];
    }
    /**
     * @test
     * @dataProvider raceToWill
     *
     * @param string $raceCode
     * @param int $will
     */
    public function I_can_get_female_will_of_any_race($raceCode, $will)
    {
        $table = new FemaleModifiersTable();

        $this->assertSame($will, $table->getWill($raceCode));
    }


    public function raceToWill()
    {
        return [
            [Human::HUMAN, 0],
            [Elf::ELF, 0],
            [Dwarf::DWARF, 0],
            [Hobbit::HOBBIT, 0],
            [Kroll::KROLL, -1],
            [Orc::ORC, 1],
        ];
    }
    /**
     * @test
     * @dataProvider raceToIntelligence
     *
     * @param string $raceCode
     * @param int $intelligence
     */
    public function I_can_get_female_intelligence_of_any_race($raceCode, $intelligence)
    {
        $table = new FemaleModifiersTable();

        $this->assertSame($intelligence, $table->getIntelligence($raceCode));
    }


    public function raceToIntelligence()
    {
        return [
            [Human::HUMAN, 0],
            [Elf::ELF, -1],
            [Dwarf::DWARF, 1],
            [Hobbit::HOBBIT, 0],
            [Kroll::KROLL, 0],
            [Orc::ORC, 0],
        ];
    }

    /**
     * @test
     * @dataProvider raceToCharisma
     *
     * @param string $raceCode
     * @param int $charisma
     */
    public function I_can_get_female_charisma_of_any_race($raceCode, $charisma)
    {
        $table = new FemaleModifiersTable();

        $this->assertSame($charisma, $table->getCharisma($raceCode));
    }


    public function raceToCharisma()
    {
        return [
            [Human::HUMAN, 1],
            [Elf::ELF, 1],
            [Dwarf::DWARF, 0],
            [Hobbit::HOBBIT, 1],
            [Kroll::KROLL, 1],
            [Orc::ORC, 0],
        ];
    }
}
