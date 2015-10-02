<?php
namespace DrdPlus\Tests\Tables\Experiences;

use DrdPlus\Tables\Experiences\ExperiencesTable;
use DrdPlus\Tables\Experiences\Level;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class LevelTest extends AbstractTestOfMeasurement
{
    /**
     * @test
     */
    public function I_can_get_level()
    {
        $level = new Level($levelValue = 456, Level::LEVEL, $this->getExperiencesTable());
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
            $value = 111,
            Level::LEVEL,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('levelToExperiences')
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
            $value = 111,
            Level::LEVEL,
            $experiencesTable = $this->getExperiencesTable()
        );
        $experiencesTable->shouldReceive('levelToTotalExperiences')
            ->atLeast()->once()
            ->with($level)
            ->andReturn($totalExperiencesValue = 222);
        $this->assertSame($totalExperiencesValue, $level->getTotalExperiences());
    }

}
