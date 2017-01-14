<?php
namespace DrdPlus\Tests\Tables\History;

use DrdPlus\Codes\History\AncestryCode;
use DrdPlus\Codes\History\BackgroundCode;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tables\History\BackgroundPointsDistributionTable;
use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

class BackgroundPointsDistributionTableTest extends TestWithMockery implements TableTestInterface
{

    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [['background', 'max_points', 'more_than_for_ancestry_up_to']],
            (new BackgroundPointsDistributionTable())->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideBackgroundAndAncestryAndExpectedMaxPoints
     * @param int $backgroundValue
     * @param int $maxPointsIfNotLimited
     * @param int $maxPointsFromAncestryToNotBeLimited
     * @param bool $canBeLimited
     */
    public function I_can_get_max_points_to_distribute_by_background(
        $backgroundValue,
        $maxPointsIfNotLimited,
        $maxPointsFromAncestryToNotBeLimited,
        $canBeLimited
    )
    {
        $ancestryCode = $this->createAncestryCode();
        self::assertSame(
            $maxPointsIfNotLimited,
            (new BackgroundPointsDistributionTable())->getMaxPointsToDistribute(
                BackgroundCode::getIt($backgroundValue),
                $this->createAncestryTable($ancestryCode, $maxPointsFromAncestryToNotBeLimited),
                $ancestryCode
            )
        );
        for ($pointsForAncestry = $maxPointsFromAncestryToNotBeLimited; $pointsForAncestry > 0; $pointsForAncestry--) {
            self::assertSame(
                $canBeLimited
                    ? ($pointsForAncestry + 3)
                    : $maxPointsIfNotLimited,
                (new BackgroundPointsDistributionTable())->getMaxPointsToDistribute(
                    BackgroundCode::getIt($backgroundValue),
                    $this->createAncestryTable($ancestryCode, $pointsForAncestry),
                    $ancestryCode
                )
            );
        }
    }

    public function provideBackgroundAndAncestryAndExpectedMaxPoints()
    {
        return [
            [BackgroundCode::ANCESTRY, 8, 8, false],
            [BackgroundCode::POSSESSION, 8, 5, true],
            [BackgroundCode::SKILLS, 8, 5, true],
        ];
    }

    /**
     * @param AncestryCode $ancestryCode
     * @param int $points
     * @return \Mockery\MockInterface|AncestryTable
     */
    private function createAncestryTable(AncestryCode $ancestryCode, $points)
    {
        $ancestryTable = $this->mockery(AncestryTable::class);
        $ancestryTable->shouldReceive('getPointsByAncestry')
            ->with($ancestryCode)
            ->andReturn($points);

        return $ancestryTable;
    }

    /**
     * @return \Mockery\MockInterface|AncestryCode
     */
    private function createAncestryCode()
    {
        return $this->mockery(AncestryCode::class);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\History\Exceptions\UnknownBackgroundCode
     * @expectedExceptionMessageRegExp ~constructed~
     */
    public function I_can_not_get_max_points_for_unknown_background()
    {
        (new BackgroundPointsDistributionTable())->getMaxPointsToDistribute(
            $this->createBackgroundCode('constructed'),
            new AncestryTable(),
            AncestryCode::getIt(AncestryCode::FOUNDLING)
        );
    }

    /**
     * @param string $value
     * @return \Mockery\MockInterface|BackgroundCode
     */
    private function createBackgroundCode($value)
    {
        $backgroundCode = $this->mockery(BackgroundCode::class);
        $backgroundCode->shouldReceive('getValue')
            ->andReturn($value);
        $backgroundCode->shouldReceive('__toString')
            ->andReturn((string)$value);

        return $backgroundCode;
    }
}