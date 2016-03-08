<?php
namespace DrdPlus\Tables\Professions;

use DrdPlus\Codes\ProfessionCodes;
use DrdPlus\Codes\SkillCodes;

class BackgroundSkillsTableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function I_can_get_headers()
    {
        $backgroundSkillsTable = new BackgroundSkillsTable();
        self::assertEquals(
            [
                ['', 'fighter', 'fighter', 'fighter', 'thief', 'thief', 'thief', 'ranger', 'ranger', 'ranger', 'wizard', 'wizard', 'wizard', 'theurgist', 'theurgist', 'theurgist', 'priest', 'priest', 'priest'],
                ['points', 'physical', 'psychical', 'combined', 'physical', 'psychical', 'combined', 'physical', 'psychical', 'combined', 'physical', 'psychical', 'combined', 'physical', 'psychical', 'combined', 'physical', 'psychical', 'combined'],
            ],
            $backgroundSkillsTable->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideSkillPointToProfession
     * @param int $backgroundSkillPoints
     * @param string $professionCode
     * @param string $skillGroup
     * @param int $expectedSkillPoints
     */
    public function I_can_get_skills_for_each_profession(
        $backgroundSkillPoints,
        $professionCode,
        $skillGroup,
        $expectedSkillPoints
    )
    {
        $table = new BackgroundSkillsTable();
        $skillPoints = $table->getSkillPoints($backgroundSkillPoints, $professionCode, $skillGroup);
        self::assertSame($expectedSkillPoints, $skillPoints);

        $getGroupSkillPoints = 'get' . ucfirst($skillGroup) . 'SkillPoints';
        $groupSkillPoints = $table->$getGroupSkillPoints($backgroundSkillPoints, $professionCode);
        self::assertSame($expectedSkillPoints, $groupSkillPoints);

        $getProfessionGroupSkillPoints = 'get' . ucfirst($professionCode) . ucfirst($skillGroup) . 'SkillPoints';
        $professionGroupSkillPoints = $table->$getProfessionGroupSkillPoints($backgroundSkillPoints);
        self::assertSame($expectedSkillPoints, $professionGroupSkillPoints);
    }

    public function provideSkillPointToProfession()
    {
        $combinations = [];
        $rowIndex = 0;
        for ($backgroundSkillPoint = 0; $backgroundSkillPoint <= 8; $backgroundSkillPoint++) {
            $columnIndex = 0;
            foreach (ProfessionCodes::getProfessionCodes() as $professionCode) {
                foreach (SkillCodes::getSkillTypes() as $type) {
                    $combinations[] = [
                        $backgroundSkillPoint,
                        $professionCode,
                        $type,
                        $this->getExpectedSkillPoints($rowIndex, $columnIndex)
                    ];
                    $columnIndex++;
                }
            }
            $rowIndex++;
        }

        return $combinations;
    }

    private $expectedSkillPoints = [
        [2, 0, 1, 1, 1, 1, 2, 0, 1, 0, 3, 0, 0, 2, 1, 0, 1, 2,],
        [3, 0, 1, 2, 1, 1, 2, 0, 2, 1, 3, 0, 0, 3, 1, 0, 2, 2,],
        [4, 0, 1, 2, 1, 2, 3, 0, 2, 1, 4, 0, 0, 4, 1, 1, 2, 2,],
        [4, 1, 2, 3, 2, 2, 3, 1, 3, 2, 4, 1, 1, 4, 2, 1, 3, 3,],
        [5, 1, 3, 4, 2, 3, 4, 1, 4, 2, 5, 2, 1, 5, 3, 2, 3, 4,],
        [6, 2, 3, 5, 2, 4, 5, 1, 5, 3, 6, 2, 2, 6, 3, 2, 4, 5,],
        [8, 2, 4, 6, 3, 5, 6, 2, 6, 4, 7, 3, 2, 8, 4, 3, 5, 6,],
        [10, 3, 5, 8, 4, 6, 8, 3, 7, 5, 9, 4, 3, 10, 5, 4, 7, 7,],
        [12, 4, 6, 9, 6, 7, 10, 4, 8, 6, 11, 5, 4, 12, 6, 5, 9, 8,]
    ];

    private function getExpectedSkillPoints($rowIndex, $columnIndex)
    {
        return $this->expectedSkillPoints[$rowIndex][$columnIndex];
    }

}
