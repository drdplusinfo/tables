<?php
namespace DrdPlus\Tests\Tables\Combat;

use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Body\Height;
use DrdPlus\Properties\Combat\BaseProperties;
use DrdPlus\Properties\Combat\Fight;
use DrdPlus\Tables\Body\CorrectionByHeightTable;
use DrdPlus\Tables\Combat\FightTable;
use DrdPlus\Tables\Tables;
use DrdPlus\Tests\Tables\TableTest;

class FightTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['profession', 'first_property', 'second_property']], (new FightTable())->getHeader());
    }

    /**
     * @test
     */
    public function I_can_get_fight()
    {
        $directFight = new Fight($profession = ProfessionCode::getIt(ProfessionCode::FIGHTER),
            $baseProperties = $this->createBaseProperties(123),
            $height = $this->createHeight(),
            $tables = $this->createTables(987));
        $fightByTable = (new FightTable())->getFightForProfession(
            $profession, $baseProperties, $height, $tables
        );
        self::assertInstanceOf(Fight::class, $fightByTable);
        self::assertSame($directFight->getValue(), $fightByTable->getValue());
    }

    /**
     * @param int $agilityValue
     * @return \Mockery\MockInterface|BaseProperties
     */
    private function createBaseProperties($agilityValue)
    {
        $baseProperties = $this->mockery(BaseProperties::class);
        $baseProperties->shouldReceive('getAgility')
            ->andReturn($agility = $this->mockery(Agility::class));
        $agility->shouldReceive('getValue')
            ->andReturn($agilityValue);

        return $baseProperties;
    }

    /**+
     * @return \Mockery\MockInterface|Height
     */
    private function createHeight()
    {
        return $this->mockery(Height::class);
    }

    /**
     * @param $correctionByHeight
     * @return \Mockery\MockInterface|Tables
     */
    private function createTables($correctionByHeight)
    {
        $tables = $this->mockery(Tables::class);
        $tables->shouldReceive('getCorrectionByHeightTable')
            ->andReturn($correctionByHeightTable = $this->mockery(CorrectionByHeightTable::class));
        $correctionByHeightTable->shouldReceive('getCorrectionByHeight')
            ->andReturn($correctionByHeight);

        return $tables;
    }

}