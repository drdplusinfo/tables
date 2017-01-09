<?php
namespace DrdPlus\Tests\Tables\History;

use DrdPlus\Codes\FateCode;
use DrdPlus\Tables\History\BackgroundPointsTable;
use DrdPlus\Tests\Tables\TableTestInterface;

class BackgroundPointsTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['fate', 'background_points']], (new BackgroundPointsTable())->getHeader());
    }

    /**
     * @test
     * @dataProvider provideChoiceAndExpectedBackgroundPoints
     * @param string $choice
     * @param int $expectedBackgroundPoints
     */
    public function I_can_get_background_points_for_choice($choice, $expectedBackgroundPoints)
    {
        $backgroundPointsTable = new BackgroundPointsTable();
        self::assertSame($expectedBackgroundPoints, $backgroundPointsTable->getBackgroundPointsByChoice($choice));
    }

    public function provideChoiceAndExpectedBackgroundPoints()
    {
        return [
            [FateCode::FATE_OF_EXCEPTIONAL_PROPERTIES, 5],
            [FateCode::FATE_OF_COMBINATION, 10],
            [FateCode::FATE_OF_GOOD_REAR, 15],
        ];
    }

}