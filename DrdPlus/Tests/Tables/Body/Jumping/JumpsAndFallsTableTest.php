<?php
namespace DrdPlus\Tests\Tables\Body\Jumping;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Codes\Environment\LandingSurfaceCode;
use DrdPlus\Codes\JumpTypeCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Body\Weight;
use DrdPlus\Properties\Derived\Athletics;
use DrdPlus\Properties\Derived\Speed;
use DrdPlus\Tables\Body\Jumping\JumpsAndFallsTable;
use DrdPlus\Tables\Environments\LandingSurfacesTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tests\Tables\TableTest;
use Granam\Integer\PositiveInteger;
use Granam\Integer\PositiveIntegerObject;

class JumpsAndFallsTableTest extends TableTest
{
    /**
     * @test
     * @dataProvider provideValuesForModifierToJump
     * @param string $jumpType
     * @param float $ranDistance
     * @param int $expectedModifierToJump
     */
    public function I_can_get_modifier_to_jump($jumpType, $ranDistance, $expectedModifierToJump)
    {
        self::assertSame(
            $expectedModifierToJump,
            (new JumpsAndFallsTable())
                ->getModifierToJump(JumpTypeCode::getIt($jumpType), $this->createDistance($ranDistance))
        );
    }

    public function provideValuesForModifierToJump()
    {
        return [
            [JumpTypeCode::HIGH_JUMP, 4.9, -6],
            [JumpTypeCode::HIGH_JUMP, 5, 3],
            [JumpTypeCode::BROAD_JUMP, 0, -3],
            [JumpTypeCode::BROAD_JUMP, 5.1, 6],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_length_of_jump()
    {
        self::assertSame(
            62 /* 123 / 2 */ - 3 + 456 + 789,
            (new JumpsAndFallsTable())
                ->getJumpLength(
                    $this->createSpeed(123),
                    $this->createAthletics(456),
                    JumpTypeCode::getIt(JumpTypeCode::BROAD_JUMP),
                    $this->createDistance(0),
                    $this->createRoll1d6(789)
                )
        );
    }

    /**
     * @param int $value
     * @return \Mockery\MockInterface|Speed
     */
    private function createSpeed($value)
    {
        $speed = $this->mockery(Speed::class);
        $speed->shouldReceive('getValue')
            ->andReturn($value);

        return $speed;
    }

    /**
     * @param int $value
     * @return \Mockery\MockInterface|Athletics
     */
    private function createAthletics($value)
    {
        $athletics = $this->mockery(Athletics::class);
        $athletics->shouldReceive('getAthleticsBonus')
            ->andReturn($athleticsBonus = $this->mockery(PositiveInteger::class));
        $athleticsBonus->shouldReceive('getValue')
            ->andReturn($value);

        return $athletics;
    }

    /**
     * @param int $value
     * @return \Mockery\MockInterface|Roll1d6
     */
    private function createRoll1d6($value)
    {
        $roll1d6 = $this->mockery(Roll1d6::class);
        $roll1d6->shouldReceive('getValue')
            ->andReturn($value);

        return $roll1d6;
    }

    /**
     * @test
     * @dataProvider provideValuesForWoundsFromJumpOrFall
     * @param int $distanceInMeters
     * @param int $bodyWeight
     * @param int $roll1d6
     * @param bool $itIsControlledJump
     * @param int $armorProtectionValue
     * @param int $modifierFromLandingSurface
     * @param int $expectedPowerOfWound
     * @param int $powerOfWoundAsWounds
     * @param int $agilityValue
     * @param int $agilityAsWounds
     * @param int $expectedWounds
     */
    public function I_can_get_wounds_from_jump_or_fall(
        $distanceInMeters,
        $bodyWeight,
        $roll1d6,
        $itIsControlledJump,
        $armorProtectionValue,
        $modifierFromLandingSurface,
        $expectedPowerOfWound,
        $powerOfWoundAsWounds,
        $agilityValue,
        $agilityAsWounds,
        $expectedWounds
    )
    {
        $wounds = (new JumpsAndFallsTable())
            ->getWoundsFromJumpOrFall(
                $this->createDistance($distanceInMeters),
                $this->createWeight($bodyWeight),
                $this->createRoll1d6($roll1d6),
                $itIsControlledJump,
                $agility = $this->createAgility($agilityValue),
                $landingSurfaceCode = $this->createLandingSurfaceCode('foo'),
                $armorProtection = new PositiveIntegerObject($armorProtectionValue),
                $this->createWoundsTable($expectedPowerOfWound, $powerOfWoundAsWounds, $agilityValue, $agilityAsWounds),
                $this->createLandingSurfacesTable($landingSurfaceCode, $agility, $armorProtection, $modifierFromLandingSurface)
            );
        self::assertInstanceOf(Wounds::class, $wounds);
        self::assertSame($expectedWounds, $wounds->getValue());
    }

    public function provideValuesForWoundsFromJumpOrFall()
    {
        // distance, weight, $roll, is controlled, armor, surface modifier, expected power of wound, powerOfWoundAsWounds, agility, agilityAsWounds, expected wounds
        return [
            [111, 222, 333, false, 444, -550, 0, 123, 555, 124 /* higher bonus from agility than wounds */, 0],
            [111, 222, 333, false, 444, -550, 0, 124, 555, 123 /* higher wounds than bonus from agility */, 1],
            [111, 222, 333, true /* controlled jump */, 444, -548, 0, 123, 555, 124, 0],
            [111, 222, 333, false /* fall */, 444, -548, 2, 123, 555, 124, 0],
            [111, 222, 333, false, 444, -999 /* very high bonus from surface */, 0, 123, 555, 123, 0],
        ];
    }

    /**
     * @param float $meters
     * @return \Mockery\MockInterface|Distance
     */
    private function createDistance($meters)
    {
        $distance = $this->mockery(Distance::class);
        $distance->shouldReceive('getMeters')
            ->andReturn($meters);

        return $distance;
    }

    /**
     * @param int $value
     * @return \Mockery\MockInterface|Weight
     */
    private function createWeight($value)
    {
        $weight = $this->mockery(Weight::class);
        $weight->shouldReceive('getValue')
            ->andReturn($value);

        return $weight;
    }

    /**
     * @param int $value
     * @return \Mockery\MockInterface|Agility
     */
    private function createAgility($value)
    {
        $agility = $this->mockery(Agility::class);
        $agility->shouldReceive('getValue')
            ->andReturn($value);

        return $agility;
    }

    /**
     * @param string $value
     * @return \Mockery\MockInterface|LandingSurfaceCode
     */
    private function createLandingSurfaceCode($value)
    {
        $landingSurfaceCode = $this->mockery(LandingSurfaceCode::class);
        $landingSurfaceCode->shouldReceive('getValue')
            ->andReturn($value);
        $landingSurfaceCode->shouldReceive('__toString')
            ->andReturn((string)$value);

        return $landingSurfaceCode;
    }

    /**
     * @param int $expectedPowerOfWound
     * @param int $powerOfWoundAsWounds
     * @param int $expectedAgilityValue
     * @param int $agilityAsWounds
     * @return \Mockery\MockInterface|WoundsTable
     */
    private function createWoundsTable($expectedPowerOfWound, $powerOfWoundAsWounds, $expectedAgilityValue, $agilityAsWounds)
    {
        $woundsTable = $this->mockery(WoundsTable::class);
        $woundsTable->shouldReceive('toWounds')
            ->with($this->type(WoundsBonus::class))
            ->andReturnUsing(function (WoundsBonus $woundsBonus)
            use ($expectedPowerOfWound, $powerOfWoundAsWounds, $expectedAgilityValue, $agilityAsWounds) {
                $wounds = $this->mockery(Wounds::class);
                if ($woundsBonus->getValue() === $expectedPowerOfWound) {
                    $wounds->shouldReceive('getValue')
                        ->andReturn($powerOfWoundAsWounds);
                } else if ($woundsBonus->getValue() === $expectedAgilityValue) {
                    $wounds->shouldReceive('getValue')
                        ->andReturn($agilityAsWounds);
                } else {
                    self::fail('Unexpected value of wounds bonus ' . var_export($woundsBonus->getValue(), true));
                }

                return $wounds;
            });

        return $woundsTable;
    }

    /**
     * @param LandingSurfaceCode $landingSurfaceCode
     * @param Agility $agility
     * @param PositiveInteger $armorProtection
     * @param int $modifier
     * @return \Mockery\MockInterface|LandingSurfacesTable
     */
    private function createLandingSurfacesTable(
        LandingSurfaceCode $landingSurfaceCode,
        Agility $agility,
        PositiveInteger $armorProtection,
        $modifier
    )
    {
        $landingSurfacesTable = $this->mockery(LandingSurfacesTable::class);
        $landingSurfacesTable->shouldReceive('getPowerOfWoundModifier')
            ->with($landingSurfaceCode, $agility, $armorProtection)
            ->andReturn($modifier);

        return $landingSurfacesTable;
    }
}