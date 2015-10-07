<?php
namespace DrdPlus\Tests\Tables\Derived\Experiences;

use DrdPlus\Tables\Experiences\Experiences;
use DrdPlus\Tables\Experiences\ExperiencesTable;
use DrdPlus\Tables\Experiences\Level;
use DrdPlus\Tables\Wounds\WoundsTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class ExperiencesTableTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_convert_experiences_to_level()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = new WoundsTable());
        $experiences = new Experiences($experiencesValue = 123, Experiences::EXPERIENCES, $experiencesTable);

        $level = $experiencesTable->toLevel($experiences);
        $this->assertInstanceOf(Level::class, $level);
        $this->assertSame(17, $level->getValue());
    }

    /**
     * @test
     */
    public function I_can_convert_level_to_experiences()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = new WoundsTable());
        $level = new Level($levelValue = 11, $experiencesTable);

        $this->assertSame(63, $experiencesTable->toExperiences($level)->getValue());
    }

    /**
     * @test
     */
    public function I_can_convert_level_to_total_experiences()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = new WoundsTable());
        $firstLevel = new Level($levelValue = 1, $experiencesTable);
        $this->assertSame(
            0,
            $experiencesTable->toTotalExperiences($firstLevel, true /* main profession */)->getValue()
        );
        $this->assertSame(
            20,
            $experiencesTable->toTotalExperiences($firstLevel, false /* collateral profession */)->getValue()
        );

        $lastLevel = new Level($levelValue = 20, $experiencesTable);
        $this->assertSame(
            1447,
            $experiencesTable->toTotalExperiences($lastLevel, true /* main profession */)->getValue()
        );
        $this->assertSame(
            1467,
            $experiencesTable->toTotalExperiences($lastLevel, false /* collateral profession */)->getValue()
        );
    }

    /**
     * @test
     */
    public function I_can_convert_experiences_to_total_level()
    {
        $experiencesTable = new ExperiencesTable($woundsTable = new WoundsTable());
        $experiences = new Experiences($experiencesValue = 99, Experiences::EXPERIENCES, $experiencesTable);

        $level = $experiencesTable->toTotalLevel($experiences);
        $this->assertSame(14, $level->getValue());
    }
}
