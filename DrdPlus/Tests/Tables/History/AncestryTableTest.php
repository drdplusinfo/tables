<?php
namespace DrdPlus\Tests\Tables\History;

use DrdPlus\Codes\History\AncestryCode;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Integer\PositiveIntegerObject;
use Granam\Tests\Tools\TestWithMockery;

class AncestryTableTest extends TestWithMockery implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['points', 'ancestry']], (new AncestryTable())->getHeader());
    }

    /**
     * @test
     * @dataProvider provideBackgroundPointsAndExpectedAncestry
     * @param int $backgroundPoints
     * @param string $expectedAncestryValue
     */
    public function I_can_get_ancestry_by_background_points($backgroundPoints, $expectedAncestryValue)
    {
        self::assertSame(
            AncestryCode::getIt($expectedAncestryValue),
            (new AncestryTable())->getAncestryByPoints(new PositiveIntegerObject($backgroundPoints))
        );
    }

    public function provideBackgroundPointsAndExpectedAncestry()
    {
        return [
            [0, AncestryCode::FOUNDLING],
            [1, AncestryCode::ORPHAN],
            [2, AncestryCode::FROM_INCOMPLETE_FAMILY],
            [3, AncestryCode::FROM_DOUBTFULLY_FAMILY],
            [4, AncestryCode::FROM_MODEST_FAMILY],
            [5, AncestryCode::FROM_WEALTHY_FAMILY],
            [6, AncestryCode::FROM_WEALTHY_AND_INFLUENTIAL_FAMILY],
            [7, AncestryCode::NOBLE],
            [8, AncestryCode::NOBLE_FROM_POWERFUL_FAMILY],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\History\Exceptions\UnexpectedBackgroundPointsForAncestry
     * @expectedExceptionMessageRegExp ~9~
     */
    public function I_can_not_get_ancestry_by_invalid_background_points()
    {
        (new AncestryTable())->getAncestryByPoints(new PositiveIntegerObject(9));
    }
}