<?php
namespace DrdPlus\Tests\Tables\Combat;

use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
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
     * @dataProvider provideProfessionAndProperties
     * @param string $professionName
     * @param string $firstProperty
     * @param string $secondProperty
     */
    public function I_can_get_fight_and_its_settings($professionName, $firstProperty, $secondProperty)
    {
        $directFight = Fight::getIt($professionCode = ProfessionCode::getIt($professionName),
            $baseProperties = $this->createBaseProperties(),
            $height = $this->createHeight(),
            $tables = $this->createTables(987));
        $fightTable = new FightTable();
        $fightByTable = $fightTable->getFightForProfession(
            $professionCode, $baseProperties, $height, $tables
        );
        self::assertInstanceOf(Fight::class, $fightByTable);
        self::assertSame($directFight->getValue(), $fightByTable->getValue());

        $fightSettings = $fightTable->getRow($professionCode);
        self::assertSame($firstProperty, $fightSettings['first_property']);
        self::assertSame($secondProperty, $fightSettings['second_property']);
    }

    public function provideProfessionAndProperties()
    {
        return [
            [ProfessionCode::FIGHTER, PropertyCode::AGILITY, false],
            [ProfessionCode::THIEF, PropertyCode::KNACK, PropertyCode::AGILITY],
            [ProfessionCode::RANGER, PropertyCode::KNACK, PropertyCode::AGILITY],
            [ProfessionCode::WIZARD, PropertyCode::INTELLIGENCE, PropertyCode::AGILITY],
            [ProfessionCode::THEURGIST, PropertyCode::INTELLIGENCE, PropertyCode::AGILITY],
            [ProfessionCode::PRIEST, PropertyCode::CHARISMA, PropertyCode::AGILITY],
        ];
    }

    /**
     * @return \Mockery\MockInterface|BaseProperties
     */
    private function createBaseProperties()
    {
        $baseProperties = $this->mockery(BaseProperties::class);
        $baseProperties->shouldReceive('getAgility')
            ->andReturn($agility = $this->mockery(Agility::class));
        $agility->shouldReceive('getValue')
            ->andReturn(123);
        $baseProperties->shouldReceive('getKnack')
            ->andReturn($knack = $this->mockery(Knack::class));
        $knack->shouldReceive('getValue')
            ->andReturn(456);
        $baseProperties->shouldReceive('getIntelligence')
            ->andReturn($intelligence = $this->mockery(Intelligence::class));
        $intelligence->shouldReceive('getValue')
            ->andReturn(789);
        $baseProperties->shouldReceive('getCharisma')
            ->andReturn($charisma = $this->mockery(Charisma::class));
        $charisma->shouldReceive('getValue')
            ->andReturn(753);

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