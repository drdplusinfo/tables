<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Body;

use DrdPlus\Calculations\SumAndRound;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Properties\Derived\Beauty;
use DrdPlus\Properties\Derived\Dangerousness;
use DrdPlus\Properties\Derived\Dignity;
use DrdPlus\Tables\Body\AspectsOfVisageTable;
use DrdPlus\Tests\Tables\TableTest;

class AspectsOfVisageTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [['aspect_of_visage', 'first_property', 'second_property', 'sum_of_first_and_second_property_divisor', 'third_property', 'third_property_divisor']],
            (new AspectsOfVisageTable())->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_beauty_and_its_definition()
    {
        $aspectsOfVisageTable = new AspectsOfVisageTable();
        $agility = Agility::getIt(123);
        $knack = Knack::getIt(456);
        $charisma = Charisma::getIt(789);
        $beauty = $aspectsOfVisageTable->getBeauty($agility, $knack, $charisma);
        self::assertInstanceOf(Beauty::class, $beauty);
        $expectedBeauty = Beauty::getIt($agility, $knack, $charisma);
        self::assertSame($expectedBeauty->getValue(), $beauty->getValue());
        $definition = $aspectsOfVisageTable->getRow(PropertyCode::BEAUTY);
        self::assertSame(PropertyCode::AGILITY, $definition[AspectsOfVisageTable::FIRST_PROPERTY]);
        self::assertSame(PropertyCode::KNACK, $definition[AspectsOfVisageTable::SECOND_PROPERTY]);
        self::assertSame(PropertyCode::CHARISMA, $definition[AspectsOfVisageTable::THIRD_PROPERTY]);
        $calculatedBeauty = ($agility->getValue() + $knack->getValue())
            / $definition[AspectsOfVisageTable::SUM_OF_FIRST_AND_SECOND_PROPERTY_DIVISOR]
            + $charisma->getValue() / $definition[AspectsOfVisageTable::THIRD_PROPERTY_DIVISOR];
        $calculatedBeauty = SumAndRound::round($calculatedBeauty);
        self::assertSame($expectedBeauty->getValue(), $calculatedBeauty);
    }

    /**
     * @test
     */
    public function I_can_get_dangerousness_and_its_definition()
    {
        $aspectsOfVisageTable = new AspectsOfVisageTable();
        $strength = Strength::getIt(123);
        $will = Will::getIt(456);
        $charisma = Charisma::getIt(789);
        $dangerousness = $aspectsOfVisageTable->getDangerousness($strength, $will, $charisma);
        self::assertInstanceOf(Dangerousness::class, $dangerousness);
        $expectedDangerousness = Dangerousness::getIt($strength, $will, $charisma);
        self::assertSame($expectedDangerousness->getValue(), $dangerousness->getValue());
        $definition = $aspectsOfVisageTable->getRow(PropertyCode::DANGEROUSNESS);
        self::assertSame(PropertyCode::STRENGTH, $definition[AspectsOfVisageTable::FIRST_PROPERTY]);
        self::assertSame(PropertyCode::WILL, $definition[AspectsOfVisageTable::SECOND_PROPERTY]);
        self::assertSame(PropertyCode::CHARISMA, $definition[AspectsOfVisageTable::THIRD_PROPERTY]);
        $calculatedDangerousness = ($strength->getValue() + $will->getValue())
            / $definition[AspectsOfVisageTable::SUM_OF_FIRST_AND_SECOND_PROPERTY_DIVISOR]
            + $charisma->getValue() / $definition[AspectsOfVisageTable::THIRD_PROPERTY_DIVISOR];
        $calculatedDangerousness = SumAndRound::round($calculatedDangerousness);
        self::assertSame($expectedDangerousness->getValue(), $calculatedDangerousness);
    }

    /**
     * @test
     */
    public function I_can_get_dignity_and_its_definition()
    {
        $aspectsOfVisageTable = new AspectsOfVisageTable();
        $intelligence = Intelligence::getIt(123);
        $will = Will::getIt(456);
        $charisma = Charisma::getIt(789);
        $dignity = $aspectsOfVisageTable->getDignity($intelligence, $will, $charisma);
        self::assertInstanceOf(Dignity::class, $dignity);
        $expectedDignity = Dignity::getIt($intelligence, $will, $charisma);
        self::assertSame($expectedDignity->getValue(), $dignity->getValue());
        $definition = $aspectsOfVisageTable->getRow(PropertyCode::DIGNITY);
        self::assertSame(PropertyCode::INTELLIGENCE, $definition[AspectsOfVisageTable::FIRST_PROPERTY]);
        self::assertSame(PropertyCode::WILL, $definition[AspectsOfVisageTable::SECOND_PROPERTY]);
        self::assertSame(PropertyCode::CHARISMA, $definition[AspectsOfVisageTable::THIRD_PROPERTY]);
        $calculatedDignity = ($intelligence->getValue() + $will->getValue())
            / $definition[AspectsOfVisageTable::SUM_OF_FIRST_AND_SECOND_PROPERTY_DIVISOR]
            + $charisma->getValue() / $definition[AspectsOfVisageTable::THIRD_PROPERTY_DIVISOR];
        $calculatedDignity = SumAndRound::round($calculatedDignity);
        self::assertSame($expectedDignity->getValue(), $calculatedDignity);
    }

}