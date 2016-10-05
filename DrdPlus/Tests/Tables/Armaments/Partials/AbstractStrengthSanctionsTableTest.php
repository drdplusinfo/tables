<?php
namespace DrdPlus\Tests\Tables\Armaments\Partials;

use DrdPlus\Tables\Armaments\Partials\AbstractStrengthSanctionsTable;
use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractStrengthSanctionsTableTest extends TestWithMockery implements TableTestInterface
{
    /**
     * @test
     */
    abstract public function I_can_get_sanctions_for_missing_strength();

    /**
     * @test
     */
    public function I_can_easily_find_out_if_can_use_armament()
    {
        $sutClass = $this->getSutClass();
        /** @var AbstractStrengthSanctionsTable $sut */
        $sut = new $sutClass();
        self::assertTrue($sut->canUseIt(-999));
        self::assertFalse($sut->canUseIt(999));
    }

    /**
     * @return string
     */
    protected function getSutClass()
    {
        return preg_replace('~[\\\]Tests([\\\].+)Test$~', '$1', static::class);
    }
}