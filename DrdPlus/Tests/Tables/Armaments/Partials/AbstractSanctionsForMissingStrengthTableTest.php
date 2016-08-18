<?php
namespace DrdPlus\Tests\Tables\Armaments\Partials;

use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractSanctionsForMissingStrengthTableTest extends TestWithMockery implements TableTestInterface
{
    /**
     * @test
     */
    abstract public function I_can_get_sanctions_for_missing_strength();
}