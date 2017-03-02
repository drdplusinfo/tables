<?php
namespace DrdPlus\Tests\Tables\Environments;

use DrdPlus\Codes\Environment\MaterialCode;
use DrdPlus\Tables\Environments\MaterialResistancesTable;
use DrdPlus\Tests\Tables\TableTest;

class MaterialResistancesTableTest extends TableTest
{
    /**
     * @test
     * @dataProvider provideMaterialCodes
     * @param string $materialCodeValue
     * @param int $expectedResistance
     */
    public function I_can_get_resistance_of_material(string $materialCodeValue, int $expectedResistance)
    {
        $materialResistancesTable = new MaterialResistancesTable();
        self::assertSame(
            $expectedResistance,
            $materialResistancesTable->getResistanceOfMaterial(MaterialCode::getIt($materialCodeValue))
        );
    }

    public function provideMaterialCodes()
    {
        return [
            [MaterialCode::CLOTH_OR_PAPER_OR_ROPE, 6],
            [MaterialCode::WOOD, 12],
            [MaterialCode::BAKED_CAY, 18],
            [MaterialCode::STONE, 24],
            [MaterialCode::BRONZE, 30],
            [MaterialCode::IRON_OR_STEEL, 36],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Environments\Exceptions\UnknownMaterialToGetResistanceFor
     * @expectedExceptionMessageRegExp ~water~
     */
    public function I_can_not_get_resistance_for_unknown_material()
    {
        (new MaterialResistancesTable())->getResistanceOfMaterial($this->createMaterialCode('water'));
    }

    /**
     * @param string $value
     * @return \Mockery\MockInterface|MaterialCode
     */
    private function createMaterialCode(string $value)
    {
        $materialCode = $this->mockery(MaterialCode::class);
        $materialCode->shouldReceive('getValue')
            ->andReturn($value);
        $materialCode->shouldReceive('__toString')
            ->andReturn($value);

        return $materialCode;
    }
}