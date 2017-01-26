<?php
namespace DrdPlus\Tests\Tables\Body;

use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Derived\Endurance;
use DrdPlus\Properties\Derived\FatigueBoundary;
use DrdPlus\Properties\Derived\Toughness;
use DrdPlus\Properties\Derived\WoundBoundary;
use DrdPlus\Tables\Body\WoundAndFatigueBoundariesTable;
use DrdPlus\Tables\Measurements\Fatigue\Fatigue;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tables\Tables;
use DrdPlus\Tests\Tables\TableTest;

class WoundAndFatigueBoundariesTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['boundary', 'property']], (new WoundAndFatigueBoundariesTable())->getHeader());
    }

    /**
     * @test
     */
    public function I_can_get_wound_boundary_and_its_settings()
    {
        $woundAndFatigueBoundariesTable = new WoundAndFatigueBoundariesTable();
        $woundBoundary = $woundAndFatigueBoundariesTable->getWoundBoundary(
            $toughness = $this->createToughness(),
            $tables = $this->createTables(123)
        );
        self::assertInstanceOf(WoundBoundary::class, $woundBoundary);
        self::assertSame(123, $woundBoundary->getValue());
        $expectedWoundBoundary = WoundBoundary::getIt($toughness, $tables);
        self::assertSame($expectedWoundBoundary->getValue(), $woundBoundary->getValue());

        $settings = $woundAndFatigueBoundariesTable->getRow(PropertyCode::WOUND_BOUNDARY);
        self::assertSame(PropertyCode::TOUGHNESS, $settings['property']);
    }

    /**
     * @return \Mockery\MockInterface|Toughness
     */
    private function createToughness()
    {
        $toughness = $this->mockery(Toughness::class);
        $toughness->shouldReceive('getValue')
            ->andReturn(456);

        return $toughness;
    }

    /**
     * @param int $woundsValue
     * @param int $fatigueValue
     * @return \Mockery\MockInterface|Tables
     */
    private function createTables($woundsValue = null, $fatigueValue = null)
    {
        $tables = $this->mockery(Tables::class);
        if ($woundsValue !== null) {
            $tables->shouldReceive('getWoundsTable')
                ->andReturn($woundsTable = $this->mockery(WoundsTable::class));
            $woundsTable->shouldReceive('toWounds')
                ->andReturn($wounds = $this->mockery(Wounds::class));
            $wounds->shouldReceive('getValue')
                ->andReturn($woundsValue);
        }
        if ($fatigueValue !== null) {
            $tables->shouldReceive('getFatigueTable')
                ->andReturn($fatigueTable = $this->mockery(FatigueTable::class));
            $fatigueTable->shouldReceive('toFatigue')
                ->andReturn($fatigue = $this->mockery(Fatigue::class));
            $fatigue->shouldReceive('getValue')
                ->andReturn($fatigueValue);
        }

        return $tables;
    }

    /**
     * @test
     */
    public function I_can_get_fatigue_boundary_and_its_settings()
    {
        $woundAndFatigueBoundariesTable = new WoundAndFatigueBoundariesTable();
        $fatigueBoundary = $woundAndFatigueBoundariesTable->getFatigueBoundary(
            $endurance = $this->createEndurance(),
            $tables = $this->createTables(null, 7854)
        );
        self::assertInstanceOf(FatigueBoundary::class, $fatigueBoundary);
        self::assertSame(7854, $fatigueBoundary->getValue());
        $expectedFatigueBoundary = FatigueBoundary::getIt($endurance, $tables);
        self::assertSame($expectedFatigueBoundary->getValue(), $fatigueBoundary->getValue());

        $settings = $woundAndFatigueBoundariesTable->getRow(PropertyCode::FATIGUE_BOUNDARY);
        self::assertSame(PropertyCode::ENDURANCE, $settings['property']);
    }

    /**
     * @return \Mockery\MockInterface|Endurance
     */
    private function createEndurance()
    {
        $endurance = $this->mockery(Endurance::class);
        $endurance->shouldReceive('getValue')
            ->andReturn(456);

        return $endurance;
    }

}