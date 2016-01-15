<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\PropertyCodes;
use DrdPlus\Codes\RaceCodes;

class FemaleModifiersTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_get_headers()
    {
        $this->assertEquals(
            ['strength', 'agility', 'knack', 'will', 'intelligence', 'charisma', 'weight', 'size'],
            $this->getFemaleModifiersTable()->getColumnsHeader()
        );
        $this->assertEquals(['race'], $this->getFemaleModifiersTable()->getRowsHeader());
    }

    /**
     * @test
     */
    public function I_can_get_human_female_modifiers()
    {
        $this->assertEquals(
            [
                PropertyCodes::STRENGTH => -1,
                PropertyCodes::AGILITY => 0,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => 0,
                PropertyCodes::INTELLIGENCE => 0,
                PropertyCodes::CHARISMA => 1,
                PropertyCodes::WEIGHT => -1,
                PropertyCodes::SIZE => -1,
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
        $this->assertEquals(
            [
                PropertyCodes::STRENGTH => -1,
                PropertyCodes::AGILITY => 0,
                PropertyCodes::KNACK => 1,
                PropertyCodes::WILL => 0,
                PropertyCodes::INTELLIGENCE => -1,
                PropertyCodes::CHARISMA => 1,
                PropertyCodes::WEIGHT => -1,
                PropertyCodes::SIZE => -1,
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
                PropertyCodes::STRENGTH => 0,
                PropertyCodes::AGILITY => 0,
                PropertyCodes::KNACK => -1,
                PropertyCodes::WILL => 0,
                PropertyCodes::INTELLIGENCE => 1,
                PropertyCodes::CHARISMA => 0,
                PropertyCodes::WEIGHT => 0,
                PropertyCodes::SIZE => 0,
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
                PropertyCodes::STRENGTH => -1,
                PropertyCodes::AGILITY => 1,
                PropertyCodes::KNACK => -1,
                PropertyCodes::WILL => 0,
                PropertyCodes::INTELLIGENCE => 0,
                PropertyCodes::CHARISMA => 1,
                PropertyCodes::WEIGHT => -1,
                PropertyCodes::SIZE => -1,
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
                PropertyCodes::STRENGTH => -1,
                PropertyCodes::AGILITY => 1,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => -1,
                PropertyCodes::INTELLIGENCE => 0,
                PropertyCodes::CHARISMA => 1,
                PropertyCodes::WEIGHT => -1,
                PropertyCodes::SIZE => -1,
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
                PropertyCodes::STRENGTH => -1,
                PropertyCodes::AGILITY => 0,
                PropertyCodes::KNACK => 0,
                PropertyCodes::WILL => 1,
                PropertyCodes::INTELLIGENCE => 0,
                PropertyCodes::CHARISMA => 0,
                PropertyCodes::WEIGHT => -1,
                PropertyCodes::SIZE => -1,
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
                RaceCodes::HUMAN => [
                    PropertyCodes::STRENGTH => -1,
                    PropertyCodes::AGILITY => 0,
                    PropertyCodes::KNACK => 0,
                    PropertyCodes::WILL => 0,
                    PropertyCodes::INTELLIGENCE => 0,
                    PropertyCodes::CHARISMA => 1,
                    PropertyCodes::WEIGHT => -1,
                    PropertyCodes::SIZE => -1,
                ],
                RaceCodes::ELF => [
                    PropertyCodes::STRENGTH => -1,
                    PropertyCodes::AGILITY => 0,
                    PropertyCodes::KNACK => 1,
                    PropertyCodes::WILL => 0,
                    PropertyCodes::INTELLIGENCE => -1,
                    PropertyCodes::CHARISMA => 1,
                    PropertyCodes::WEIGHT => -1,
                    PropertyCodes::SIZE => -1,
                ],
                RaceCodes::DWARF => [
                    PropertyCodes::STRENGTH => 0,
                    PropertyCodes::AGILITY => 0,
                    PropertyCodes::KNACK => -1,
                    PropertyCodes::WILL => 0,
                    PropertyCodes::INTELLIGENCE => 1,
                    PropertyCodes::CHARISMA => 0,
                    PropertyCodes::WEIGHT => 0,
                    PropertyCodes::SIZE => 0,
                ],
                RaceCodes::HOBBIT => [
                    PropertyCodes::STRENGTH => -1,
                    PropertyCodes::AGILITY => 1,
                    PropertyCodes::KNACK => -1,
                    PropertyCodes::WILL => 0,
                    PropertyCodes::INTELLIGENCE => 0,
                    PropertyCodes::CHARISMA => 1,
                    PropertyCodes::WEIGHT => -1,
                    PropertyCodes::SIZE => -1,
                ],
                RaceCodes::KROLL => [
                    PropertyCodes::STRENGTH => -1,
                    PropertyCodes::AGILITY => 1,
                    PropertyCodes::KNACK => 0,
                    PropertyCodes::WILL => -1,
                    PropertyCodes::INTELLIGENCE => 0,
                    PropertyCodes::CHARISMA => 1,
                    PropertyCodes::WEIGHT => -1,
                    PropertyCodes::SIZE => -1,
                ],
                RaceCodes::ORC => [
                    PropertyCodes::STRENGTH => -1,
                    PropertyCodes::AGILITY => 0,
                    PropertyCodes::KNACK => 0,
                    PropertyCodes::WILL => 1,
                    PropertyCodes::INTELLIGENCE => 0,
                    PropertyCodes::CHARISMA => 0,
                    PropertyCodes::WEIGHT => -1,
                    PropertyCodes::SIZE => -1,
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
            [RaceCodes::HUMAN, -1],
            [RaceCodes::ELF, -1],
            [RaceCodes::DWARF, 0],
            [RaceCodes::HOBBIT, -1],
            [RaceCodes::KROLL, -1],
            [RaceCodes::ORC, -1],
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
            [RaceCodes::HUMAN, 0],
            [RaceCodes::ELF, 0],
            [RaceCodes::DWARF, 0],
            [RaceCodes::HOBBIT, 1],
            [RaceCodes::KROLL, 1],
            [RaceCodes::ORC, 0],
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
            [RaceCodes::HUMAN, 0],
            [RaceCodes::ELF, 1],
            [RaceCodes::DWARF, -1],
            [RaceCodes::HOBBIT, -1],
            [RaceCodes::KROLL, 0],
            [RaceCodes::ORC, 0],
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
            [RaceCodes::HUMAN, 0],
            [RaceCodes::ELF, 0],
            [RaceCodes::DWARF, 0],
            [RaceCodes::HOBBIT, 0],
            [RaceCodes::KROLL, -1],
            [RaceCodes::ORC, 1],
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
            [RaceCodes::HUMAN, 0],
            [RaceCodes::ELF, -1],
            [RaceCodes::DWARF, 1],
            [RaceCodes::HOBBIT, 0],
            [RaceCodes::KROLL, 0],
            [RaceCodes::ORC, 0],
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
            [RaceCodes::HUMAN, 1],
            [RaceCodes::ELF, 1],
            [RaceCodes::DWARF, 0],
            [RaceCodes::HOBBIT, 1],
            [RaceCodes::KROLL, 1],
            [RaceCodes::ORC, 0],
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

        $this->assertSame($charisma, $table->getWeightBonus($raceCode));
        // weight modifier has to be same as strength modifier
        $this->assertSame($table->getStrength($raceCode), $table->getWeightBonus($raceCode));
    }

    public function raceToWeight()
    {
        return [
            [RaceCodes::HUMAN, -1],
            [RaceCodes::ELF, -1],
            [RaceCodes::DWARF, 0],
            [RaceCodes::HOBBIT, -1],
            [RaceCodes::KROLL, -1],
            [RaceCodes::ORC, -1],
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

        $this->assertSame($size, $table->getSize($raceCode));
        // size modifier has to be same as strength modifier
        $this->assertSame($table->getStrength($raceCode), $table->getSize($raceCode));
    }

    public function raceToSize()
    {
        return [
            [RaceCodes::HUMAN, -1],
            [RaceCodes::ELF, -1],
            [RaceCodes::DWARF, 0],
            [RaceCodes::HOBBIT, -1],
            [RaceCodes::KROLL, -1],
            [RaceCodes::ORC, -1],
        ];
    }
}
