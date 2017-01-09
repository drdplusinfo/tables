<?php
namespace DrdPlus\Tests\Tables\Attacks\Partials;

use DrdPlus\Tables\Attacks\Partials\AbstractAttackNumberByDistanceTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractAttackNumberByDistanceTableTest extends TestWithMockery implements TableTestInterface
{
    /**
     * @test
     * @param float $distanceInMeters
     * @param int $expectedAttackNumberModifier
     * @dataProvider provideDistanceAndExpectedModifier
     */
    public function I_can_get_attack_number_modifier_by_distance($distanceInMeters, $expectedAttackNumberModifier)
    {
        $sutClass = self::getSutClass();
        /** @var AbstractAttackNumberByDistanceTable $sut */
        $sut = new $sutClass();
        self::assertSame(
            $expectedAttackNumberModifier,
            $sut->getAttackNumberModifierByDistance($this->createDistance($distanceInMeters))
        );
    }

    /**
     * @return array|mixed[][]
     */
    abstract public function provideDistanceAndExpectedModifier();

    /**
     * @param int $distanceInMeters
     * @return \Mockery\MockInterface|Distance
     */
    protected function createDistance($distanceInMeters)
    {
        $distance = $this->mockery(Distance::class);
        $distance->shouldReceive('getMeters')
            ->andReturn($distanceInMeters);

        return $distance;
    }
}