<?php
namespace DrdPlus\Tests\Tables\Measurements\Experiences;

use DrdPlus\Tables\Measurements\BonusInterface;
use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use DrdPlus\Tables\Measurements\Experiences\Level;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfBonus;

class LevelTest extends AbstractTestOfBonus
{
    /**
     * @test
     */
    public function I_can_create_bonus()
    {
        $sut = $this->createSut($value = 20);
        $this->assertInstanceOf(BonusInterface::class, $sut);
        $this->assertSame($value, $sut->getValue());
    }

    protected function getTableInstance()
    {
        return new ExperiencesTable(new WoundsTable());
    }

    protected function getNameOfMeasurementGetter()
    {
        return 'getExperiences';
    }

    protected function getMeasurementClass()
    {
        return Experiences::class;
    }

    /**
     * @test
     */
    public function I_can_get_level()
    {
        $level = new Level($levelValue = 20, $this->getExperiencesTable());
        $this->assertSame($levelValue, $level->getValue());
    }

    protected function findTable()
    {
        return $this->getExperiencesTable();
    }

    /**
     * @return ExperiencesTable|\Mockery\MockInterface
     */
    private function getExperiencesTable()
    {
        return $this->mockery(ExperiencesTable::class);
    }

    /**
     * @test
     */
    public function I_can_get_experiences()
    {
        $level = new Level(
            $value = 11,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('toExperiences')
            ->atLeast()->once()
            ->with($level)
            ->andReturn($experiencesValue = 222);
        $this->assertSame($experiencesValue, $level->getExperiences());
    }

    /**
     * @test
     */
    public function I_can_get_total_experiences()
    {
        $level = new Level(
            $value = 10,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('toTotalExperiences')
            ->atLeast()->once()
            ->with($level, true)
            ->andReturn($totalExperiencesValue = 222);
        $this->assertSame(
            $totalExperiencesValue,
            $level->getTotalExperiences(true /* for main profession */)
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Experiences\Exceptions\MaxLevelOverflow
     */
    public function I_cannot_create_higher_level_than_cap()
    {
        new Level(21, $this->getExperiencesTable());
    }

}
