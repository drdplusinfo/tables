<?php
namespace DrdPlus\Tests\Tables\Races;

use DrdPlus\Codes\PropertyCode;
use DrdPlus\Codes\RaceCode;
use DrdPlus\Tables\Races\FemaleModifiersTable;

class FemaleModifiersTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_get_headers()
    {
        self::assertEquals(
            [['race', 'strength', 'agility', 'knack', 'will', 'intelligence', 'charisma', 'weight', 'size']],
            $this->getFemaleModifiersTable()->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_human_female_modifiers()
    {
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -1,
                PropertyCode::AGILITY => 0,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => 0,
                PropertyCode::INTELLIGENCE => 0,
                PropertyCode::CHARISMA => 1,
                PropertyCode::WEIGHT => -1,
                PropertyCode::SIZE => -1,
            ],
            $this->getFemaleModifiersTable()->getHumanModifiers()
        );
    }

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
    public function I_can_get_elf_female_modifiers()
    {
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -1,
                PropertyCode::AGILITY => 0,
                PropertyCode::KNACK => 1,
                PropertyCode::WILL => 0,
                PropertyCode::INTELLIGENCE => -1,
                PropertyCode::CHARISMA => 1,
                PropertyCode::WEIGHT => -1,
                PropertyCode::SIZE => -1,
            ],
            $this->getFemaleModifiersTable()->getElfModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_dwarf_female_modifiers()
    {
        self::assertEquals(
            [
                PropertyCode::STRENGTH => 0,
                PropertyCode::AGILITY => 0,
                PropertyCode::KNACK => -1,
                PropertyCode::WILL => 0,
                PropertyCode::INTELLIGENCE => 1,
                PropertyCode::CHARISMA => 0,
                PropertyCode::WEIGHT => 0,
                PropertyCode::SIZE => 0,
            ],
            $this->getFemaleModifiersTable()->getDwarfModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_hobbit_female_modifiers()
    {
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -1,
                PropertyCode::AGILITY => 1,
                PropertyCode::KNACK => -1,
                PropertyCode::WILL => 0,
                PropertyCode::INTELLIGENCE => 0,
                PropertyCode::CHARISMA => 1,
                PropertyCode::WEIGHT => -1,
                PropertyCode::SIZE => -1,
            ],
            $this->getFemaleModifiersTable()->getHobbitModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_kroll_female_modifiers()
    {
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -1,
                PropertyCode::AGILITY => 1,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => -1,
                PropertyCode::INTELLIGENCE => 0,
                PropertyCode::CHARISMA => 1,
                PropertyCode::WEIGHT => -1,
                PropertyCode::SIZE => -1,
            ],
            $this->getFemaleModifiersTable()->getKrollModifiers()
        );
    }

    /**
     * @test
     */
    public function I_can_get_orc_female_modifiers()
    {
        self::assertEquals(
            [
                PropertyCode::STRENGTH => -1,
                PropertyCode::AGILITY => 0,
                PropertyCode::KNACK => 0,
                PropertyCode::WILL => 1,
                PropertyCode::INTELLIGENCE => 0,
                PropertyCode::CHARISMA => 0,
                PropertyCode::WEIGHT => -1,
                PropertyCode::SIZE => -1,
            ],
            $this->getFemaleModifiersTable()->getOrcModifiers()
        );
    }

    /**
     * @test
     */
    public function I_got_expected_values()
    {
        self::assertEquals(
            [
                RaceCode::HUMAN => [
                    PropertyCode::STRENGTH => -1,
                    PropertyCode::AGILITY => 0,
                    PropertyCode::KNACK => 0,
                    PropertyCode::WILL => 0,
                    PropertyCode::INTELLIGENCE => 0,
                    PropertyCode::CHARISMA => 1,
                    PropertyCode::WEIGHT => -1,
                    PropertyCode::SIZE => -1,
                ],
                RaceCode::ELF => [
                    PropertyCode::STRENGTH => -1,
                    PropertyCode::AGILITY => 0,
                    PropertyCode::KNACK => 1,
                    PropertyCode::WILL => 0,
                    PropertyCode::INTELLIGENCE => -1,
                    PropertyCode::CHARISMA => 1,
                    PropertyCode::WEIGHT => -1,
                    PropertyCode::SIZE => -1,
                ],
                RaceCode::DWARF => [
                    PropertyCode::STRENGTH => 0,
                    PropertyCode::AGILITY => 0,
                    PropertyCode::KNACK => -1,
                    PropertyCode::WILL => 0,
                    PropertyCode::INTELLIGENCE => 1,
                    PropertyCode::CHARISMA => 0,
                    PropertyCode::WEIGHT => 0,
                    PropertyCode::SIZE => 0,
                ],
                RaceCode::HOBBIT => [
                    PropertyCode::STRENGTH => -1,
                    PropertyCode::AGILITY => 1,
                    PropertyCode::KNACK => -1,
                    PropertyCode::WILL => 0,
                    PropertyCode::INTELLIGENCE => 0,
                    PropertyCode::CHARISMA => 1,
                    PropertyCode::WEIGHT => -1,
                    PropertyCode::SIZE => -1,
                ],
                RaceCode::KROLL => [
                    PropertyCode::STRENGTH => -1,
                    PropertyCode::AGILITY => 1,
                    PropertyCode::KNACK => 0,
                    PropertyCode::WILL => -1,
                    PropertyCode::INTELLIGENCE => 0,
                    PropertyCode::CHARISMA => 1,
                    PropertyCode::WEIGHT => -1,
                    PropertyCode::SIZE => -1,
                ],
                RaceCode::ORC => [
                    PropertyCode::STRENGTH => -1,
                    PropertyCode::AGILITY => 0,
                    PropertyCode::KNACK => 0,
                    PropertyCode::WILL => 1,
                    PropertyCode::INTELLIGENCE => 0,
                    PropertyCode::CHARISMA => 0,
                    PropertyCode::WEIGHT => -1,
                    PropertyCode::SIZE => -1,
                ],
            ],
            $this->getFemaleModifiersTable()->getIndexedValues()
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

        self::assertSame($strength, $table->getStrength($raceCode));
    }

    public function raceToStrength()
    {
        return [
            [RaceCode::HUMAN, -1],
            [RaceCode::ELF, -1],
            [RaceCode::DWARF, 0],
            [RaceCode::HOBBIT, -1],
            [RaceCode::KROLL, -1],
            [RaceCode::ORC, -1],
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

        self::assertSame($agility, $table->getAgility($raceCode));
    }

    public function raceToAgility()
    {
        return [
            [RaceCode::HUMAN, 0],
            [RaceCode::ELF, 0],
            [RaceCode::DWARF, 0],
            [RaceCode::HOBBIT, 1],
            [RaceCode::KROLL, 1],
            [RaceCode::ORC, 0],
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

        self::assertSame($knack, $table->getKnack($raceCode));
    }

    public function raceToKnack()
    {
        return [
            [RaceCode::HUMAN, 0],
            [RaceCode::ELF, 1],
            [RaceCode::DWARF, -1],
            [RaceCode::HOBBIT, -1],
            [RaceCode::KROLL, 0],
            [RaceCode::ORC, 0],
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

        self::assertSame($will, $table->getWill($raceCode));
    }

    public function raceToWill()
    {
        return [
            [RaceCode::HUMAN, 0],
            [RaceCode::ELF, 0],
            [RaceCode::DWARF, 0],
            [RaceCode::HOBBIT, 0],
            [RaceCode::KROLL, -1],
            [RaceCode::ORC, 1],
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

        self::assertSame($intelligence, $table->getIntelligence($raceCode));
    }

    public function raceToIntelligence()
    {
        return [
            [RaceCode::HUMAN, 0],
            [RaceCode::ELF, -1],
            [RaceCode::DWARF, 1],
            [RaceCode::HOBBIT, 0],
            [RaceCode::KROLL, 0],
            [RaceCode::ORC, 0],
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

        self::assertSame($charisma, $table->getCharisma($raceCode));
    }

    public function raceToCharisma()
    {
        return [
            [RaceCode::HUMAN, 1],
            [RaceCode::ELF, 1],
            [RaceCode::DWARF, 0],
            [RaceCode::HOBBIT, 1],
            [RaceCode::KROLL, 1],
            [RaceCode::ORC, 0],
        ];
    }

    /**
     * @test
     * @dataProvider raceToWeight
     *
     * @param string $raceCode
     * @param int $charisma
     */
    public function I_can_get_female_weight_simple_bonus_of_any_race($raceCode, $charisma)
    {
        $table = new FemaleModifiersTable();

        self::assertSame($charisma, $table->getWeightBonus($raceCode));
        // weight modifier has to be same as strength modifier
        self::assertSame($table->getStrength($raceCode), $table->getWeightBonus($raceCode));
    }

    public function raceToWeight()
    {
        return [
            [RaceCode::HUMAN, -1],
            [RaceCode::ELF, -1],
            [RaceCode::DWARF, 0],
            [RaceCode::HOBBIT, -1],
            [RaceCode::KROLL, -1],
            [RaceCode::ORC, -1],
        ];
    }

    /**
     * @test
     * @dataProvider raceToSize
     *
     * @param string $raceCode
     * @param int $size
     */
    public function I_can_get_female_size_of_any_race($raceCode, $size)
    {
        $table = new FemaleModifiersTable();

        self::assertSame($size, $table->getSize($raceCode));
        // size modifier has to be same as strength modifier
        self::assertSame($table->getStrength($raceCode), $table->getSize($raceCode));
    }

    public function raceToSize()
    {
        return [
            [RaceCode::HUMAN, -1],
            [RaceCode::ELF, -1],
            [RaceCode::DWARF, 0],
            [RaceCode::HOBBIT, -1],
            [RaceCode::KROLL, -1],
            [RaceCode::ORC, -1],
        ];
    }
}
