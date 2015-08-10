<?php
namespace DrdPlus\Tests\Tables\Experiences;

use DrdPlus\Tables\Experiences\LevelMeasurement;
use DrdPlus\Tables\Experiences\ExperiencesTable;

class LevelMeasurementTest extends AbstractTestOfExperiencesMeasurement
{
    /**
     * @test
     */
    public function I_can_get_level()
    {
        $LevelMeasurement = LevelMeasurement::getIt($level = 123, $this->getExperiencesTable());
        $this->assertSame($level, $LevelMeasurement->getValue());
        $this->assertSame($level, $LevelMeasurement->toLevel());
        $LevelMeasurement = new LevelMeasurement($level = 456, LevelMeasurement::LEVEL, $this->getExperiencesTable());
        $this->assertSame($level, $LevelMeasurement->getValue());
        $this->assertSame($level, $LevelMeasurement->toLevel());
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
        $LevelMeasurement = LevelMeasurement::getIt(
            $level = 123,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('levelToExperiences')
            ->atLeast()->once()
            ->with($level)
            ->andReturn($experiences = 456);
        $this->assertSame($experiences, $LevelMeasurement->toExperiences());
        $LevelMeasurement = new LevelMeasurement(
            $level = 111,
            LevelMeasurement::LEVEL,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('levelToExperiences')
            ->atLeast()->once()
            ->with($level)
            ->andReturn($experiences = 222);
        $this->assertSame($experiences, $LevelMeasurement->toExperiences());
    }
    /**
     * @test
     */
    public function I_can_get_total_experiences()
    {
        $LevelMeasurement = LevelMeasurement::getIt(
            $value = 123,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('levelToTotalExperiences')
            ->atLeast()->once()
            ->with($value)
            ->andReturn($level = 456);
        $this->assertSame($level, $LevelMeasurement->toTotalExperiences());
        $LevelMeasurement = new LevelMeasurement(
            $value = 111,
            LevelMeasurement::LEVEL,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('levelToTotalExperiences')
            ->atLeast()->once()
            ->with($value)
            ->andReturn($level = 222);
        $this->assertSame($level, $LevelMeasurement->toTotalExperiences());
    }

}
