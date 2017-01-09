<?php
namespace DrdPlus\Tests\Tables\History;

use DrdPlus\Codes\FateCode;
use DrdPlus\Tables\History\BackgroundPointsTable;
use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

class BackgroundPointsTableTest extends TestWithMockery implements TableTestInterface
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
     * @param string $fate
     * @param int $expectedBackgroundPoints
     */
    public function I_can_get_background_points_for_fate($fate, $expectedBackgroundPoints)
    {
        $backgroundPointsTable = new BackgroundPointsTable();
        self::assertSame(
            $expectedBackgroundPoints,
            $backgroundPointsTable->getBackgroundPointsByFate(FateCode::getIt($fate))
        );
    }

    public function provideChoiceAndExpectedBackgroundPoints()
    {
        return [
            [FateCode::FATE_OF_EXCEPTIONAL_PROPERTIES, 5],
            [FateCode::FATE_OF_COMBINATION, 10],
            [FateCode::FATE_OF_GOOD_REAR, 15],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\History\Exceptions\UnknownChoice
     * @expectedExceptionMessageRegExp ~homeless~
     */
    public function I_can_not_get_background_points_for_unknown_fate()
    {
        (new BackgroundPointsTable())->getBackgroundPointsByFate($this->createFate('homeless'));
    }

    /**
     * @param string $value
     * @return \Mockery\MockInterface|FateCode
     */
    private function createFate($value)
    {
        $fate = $this->mockery(FateCode::class);
        $fate->shouldReceive('getValue')
            ->andReturn($value);
        $fate->shouldReceive('__toString')
            ->andReturn((string)$value);

        return $fate;
    }
}