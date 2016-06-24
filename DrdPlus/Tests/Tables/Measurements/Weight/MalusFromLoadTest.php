<?php
namespace DrdPlus\Tests\Tables\Measurements\Weight;

use DrdPlus\Tables\Measurements\Weight\MalusFromLoad;
use Granam\Tests\Tools\TestWithMockery;

class MalusFromLoadTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $malusFromLoad = new MalusFromLoad(-1);
        self::assertSame(-1, $malusFromLoad->getValue());
        $zeroMalusFromLoad = new MalusFromLoad(0);
        self::assertSame(0, $zeroMalusFromLoad->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Weight\Exceptions\MalusFromLoadCanNotBePositive
     */
    public function I_can_not_create_positive_malus()
    {
        new MalusFromLoad(1);
    }
}
