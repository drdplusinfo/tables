<?php
namespace DrdPlus\Tests\Tables\Experiences;

use DrdPlus\Tables\Experiences\Experiences;
use DrdPlus\Tables\Experiences\ExperiencesTable;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class ExperiencesTest extends AbstractTestOfMeasurement
{
    /**
     * @test
     */
    public function I_can_get_experiences()
    {
        $experiences = new Experiences($value = 456, Experiences::EXPERIENCES, $this->getExperiencesTable());
        $this->assertSame($value, $experiences->getValue());
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
        $experiences = new Experiences(
            $value = 111,
            Experiences::EXPERIENCES,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('experiencesToLevel')
            ->atLeast()->once()
            ->with($experiences)
            ->andReturn($level = 222);
        $this->assertSame($level, $experiences->getLevel());
    }

    /**
     * @test
     */
    public function I_can_get_total_level()
    {
        $experiences = new Experiences(
            $value = 123,
            Experiences::EXPERIENCES,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('experiencesToTotalLevel')
            ->atLeast()->once()
            ->with($experiences)
            ->andReturn($level = 456);
        $this->assertSame($level, $experiences->getTotalLevel());
    }

}
