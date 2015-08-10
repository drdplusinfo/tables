<?php
namespace DrdPlus\Tests\Tables\Experiences;

use DrdPlus\Tables\Experiences\ExperiencesMeasurement;
use DrdPlus\Tables\Experiences\ExperiencesTable;

class ExperiencesMeasurementTest extends AbstractTestOfExperiencesMeasurement
{
    /**
     * @test
     */
    public function I_can_get_experiences()
    {
        $experiencesMeasurement = ExperiencesMeasurement::getIt($value = 123, $this->getExperiencesTable());
        $this->assertSame($value, $experiencesMeasurement->getValue());
        $this->assertSame($value, $experiencesMeasurement->toExperiences());
        $experiencesMeasurement = new ExperiencesMeasurement($value = 456, ExperiencesMeasurement::EXPERIENCES, $this->getExperiencesTable());
        $this->assertSame($value, $experiencesMeasurement->getValue());
        $this->assertSame($value, $experiencesMeasurement->toExperiences());
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
    public function I_can_get_level()
    {
        $experiencesMeasurement = ExperiencesMeasurement::getIt(
            $value = 123,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('experiencesToLevel')
            ->atLeast()->once()
            ->with($value)
            ->andReturn($level = 456);
        $this->assertSame($level, $experiencesMeasurement->toLevel());
        $experiencesMeasurement = new ExperiencesMeasurement(
            $value = 111,
            ExperiencesMeasurement::EXPERIENCES,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('experiencesToLevel')
            ->atLeast()->once()
            ->with($value)
            ->andReturn($level = 222);
        $this->assertSame($level, $experiencesMeasurement->toLevel());
    }
    /**
     * @test
     */
    public function I_can_get_total_level()
    {
        $experiencesMeasurement = ExperiencesMeasurement::getIt(
            $value = 123,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('experiencesToTotalLevel')
            ->atLeast()->once()
            ->with($value)
            ->andReturn($level = 456);
        $this->assertSame($level, $experiencesMeasurement->toTotalLevel());
        $experiencesMeasurement = new ExperiencesMeasurement(
            $value = 111,
            ExperiencesMeasurement::EXPERIENCES,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('experiencesToTotalLevel')
            ->atLeast()->once()
            ->with($value)
            ->andReturn($level = 222);
        $this->assertSame($level, $experiencesMeasurement->toTotalLevel());
    }

}
