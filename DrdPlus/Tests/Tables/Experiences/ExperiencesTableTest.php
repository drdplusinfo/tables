<?php
namespace DrdPlus\Tests\Tables\Experiences;

use DrdPlus\Tables\Experiences\ExperiencesMeasurement;
use DrdPlus\Tables\Experiences\ExperiencesTable;
use DrdPlus\Tables\Experiences\LevelMeasurement;
use DrdPlus\Tables\MeasurementInterface;
use DrdPlus\Tables\Wounds\WoundsTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class ExperiencesTableTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_convert_experiences_to_bonus()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());
        $measurement = $this->createMeasurement(ExperiencesMeasurement::EXPERIENCES);
        $measurement->shouldReceive('getValue')
            ->atLeast()->once()
            ->andReturn($value = 123);
        $measurement->shouldNotReceive('toExperiences');
        $woundsTable->shouldReceive('woundsToBonus')
            ->atLeast()->once()
            ->with($value)
            ->andReturn($bonus = 456);
        $this->assertSame($bonus, $experiencesTable->toBonus($measurement));
    }

    /**
     * @return \Mockery\MockInterface|WoundsTable
     */
    private function createWoundsTable()
    {
        return $this->mockery(WoundsTable::class);
    }

    /**
     * @param string $unit
     *
     * @return \Mockery\MockInterface|MeasurementInterface
     */
    private function createMeasurement($unit)
    {
        $measurement = $this->mockery(MeasurementInterface::class);
        $measurement->shouldReceive('getUnit')
            ->atLeast()->once()
            ->andReturn($unit);

        return $measurement;
    }

    /**
     * @test
     */
    public function I_can_convert_level_measurement_to_bonus()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());

        $levelMeasurement = $this->createMeasurement(LevelMeasurement::LEVEL);
        $levelMeasurement->shouldReceive('getValue')
            ->atLeast()->once()
            ->andReturn($levelValue = 123);
        $woundsTable->shouldReceive('woundsToBonus')
            ->with($levelValue)
            ->atLeast()->once()
            ->andReturn($bonus = 111);

        $this->assertSame($bonus + 15, $experiencesTable->toBonus($levelMeasurement));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_cannot_use_unknown_unit_for_to_bonus_conversion()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());
        $measurement = $this->createMeasurement('non-existing-unit');
        $experiencesTable->toBonus($measurement);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_cannot_use_unknown_unit_for_to_measurement_conversion()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());
        $experiencesTable->toMeasurement(123, 'non-existing-unit');
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_experiences()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());
        $experiencesBonus = 111;
        $woundsTable->shouldReceive('toWounds')
            ->atLeast()->once()
            ->with($experiencesBonus)
            ->andReturn($woundsValueAsExperiences = 456);

        $this->assertSame($woundsValueAsExperiences, $experiencesTable->toExperiences($experiencesBonus));
        $this->assertSame($woundsValueAsExperiences, $experiencesTable->toExperiencesMeasurement($experiencesBonus)->getValue());
        $this->assertSame(
            $woundsValueAsExperiences,
            $experiencesTable->toMeasurement($experiencesBonus, ExperiencesMeasurement::EXPERIENCES)->getValue()
        );
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_level()
    {
        $experiencesBonus = 111;
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());
        $woundsTable->shouldReceive('toWounds')
            ->atLeast()->once()
            ->with($experiencesBonus - 15)
            ->andReturn($woundsValueAsLevel = 456);

        $this->assertSame($woundsValueAsLevel, $experiencesTable->toLevel($experiencesBonus));
        $this->assertSame(
            $woundsValueAsLevel,
            $experiencesTable->toLevelMeasurement($experiencesBonus)->getValue()
        );
        $this->assertSame(
            $woundsValueAsLevel,
            $experiencesTable->toMeasurement($experiencesBonus, LevelMeasurement::LEVEL)->getValue()
        );
    }

    /**
     * @test
     */
    public function I_can_convert_experiences_to_level()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());

        $experiencesValue = 123;
        $woundsTable->shouldReceive('woundsToBonus')
            ->atLeast()->once()
            ->with($experiencesValue)
            ->andReturn($experiencesBonus = 111);

        $woundsTable->shouldReceive('toWounds')
            ->atLeast()->once()
            ->with($experiencesBonus - 15)
            ->andReturn($woundsValueAsLevel = 456);

        $this->assertSame($woundsValueAsLevel, $experiencesTable->experiencesToLevel($experiencesValue));
    }

    /**
     * @test
     */
    public function I_can_convert_level_to_experiences()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());
        $levelValue = 123;

        $woundsTable->shouldReceive('toWounds')
            ->atLeast()->once()
            ->with($levelValue + 15)
            ->andReturn($experiencesValue = 456);

        $this->assertSame($experiencesValue, $experiencesTable->levelToExperiences($levelValue));
    }

    /**
     * @test
     */
    public function I_can_convert_level_to_total_experiences()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());
        $levelValue = 10;

        $woundsTable->shouldReceive('toWounds')
            ->atLeast()->once()
            ->andReturnValues($values = [123, 456, 789, 111, 222, 333, 444, 555, 666, 777]);

        $this->assertSame(array_sum($values), $experiencesTable->levelToTotalExperiences($levelValue));
    }

    /**
     * @test
     */
    public function I_can_convert_experiences_to_total_level()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = $this->createWoundsTable());

        $experiencesValue = 100;
        $experiencesBonus = null;
        $woundsTable->shouldReceive('woundsToBonus')// experiences to bonus
        ->atLeast()->once()
            ->andReturnUsing(
                function () use (&$experiencesBonus, $experiencesValue) {
                    $experiences = func_get_arg(0);
                    $this->assertLessThanOrEqual($experiencesValue, $experiences);
                    $experiencesBonus = (int)round($experiences / 5);

                    return $experiencesBonus;
                }
            );

        $level = null;
        $woundsTable->shouldReceive('toWounds')// experiences bonus has been converted to level bonus, respective level itself
        ->atLeast()->once()
            ->andReturnUsing(function () use (&$experiencesBonus, &$level) {
                $levelBonus = func_get_arg(0);
                $this->assertSame($experiencesBonus - 15, $levelBonus);
                $level = $levelBonus;

                return $level > 0
                    ? $level
                    : 0;
            });

        $this->assertSame(15, $experiencesTable->experiencesToTotalLevel($experiencesValue));
    }
}
