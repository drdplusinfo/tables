<?php
namespace DrdPlus\Tests\Tables\Body;

use DrdPlus\Properties\Body\Height;
use DrdPlus\Tables\Body\CorrectionByHeightTable;
use DrdPlus\Tests\Tables\TableTest;

class CorrectionByHeightTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['height', 'correction']], (new CorrectionByHeightTable())->getHeader());
    }

    /**
     * @test
     * @dataProvider provideHeightAndExpectedCorrection
     * @param int $height
     * @param int $expectedCorrection
     */
    public function I_can_get_correction_by_height($height, $expectedCorrection)
    {
        self::assertSame(
            $expectedCorrection,
            (new CorrectionByHeightTable())->getCorrectionByHeight($this->createHeight($height))
        );
    }

    public function provideHeightAndExpectedCorrection()
    {
        return [
            [1, -1],
            [2, -1],
            [3, -1],
            [4, 0],
            [5, 0],
            [6, 0],
            [7, 1],
            [8, 1],
            [9, 1],
        ];
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Height
     */
    private function createHeight($value)
    {
        $height = $this->mockery(Height::class);
        $height->shouldReceive('getValue')
            ->andReturn($value);
        $height->shouldReceive('__toString')
            ->andReturn((string)$value);

        return $height;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\Exceptions\UnexpectedHeightToGetCorrectionFor
     * @expectedExceptionMessageRegExp ~0~
     */
    public function I_can_not_get_correction_for_too_low_height()
    {
        (new CorrectionByHeightTable())->getCorrectionByHeight($this->createHeight(0));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\Exceptions\UnexpectedHeightToGetCorrectionFor
     * @expectedExceptionMessageRegExp ~10~
     */
    public function I_can_not_get_correction_for_too_high_height()
    {
        (new CorrectionByHeightTable())->getCorrectionByHeight($this->createHeight(10));
    }
}