<?php
namespace DrdPlus\Tables\Equipment\Riding;

use DrdPlus\Codes\Transport\RidingAnimalCode;
use DrdPlus\Codes\Transport\RidingAnimalPropertyCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tools\Calculations\SumAndRound;

class RidingAnimalsTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/riding_animals.csv';
    }

    const ANIMAL = 'animal';

    protected function getRowsHeader()
    {
        return [self::ANIMAL];
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            RidingAnimalPropertyCode::SPEED => self::INTEGER,
            RidingAnimalPropertyCode::ENDURANCE => self::INTEGER,
            RidingAnimalPropertyCode::MAXIMAL_LOAD => self::INTEGER,
            RidingAnimalPropertyCode::MAXIMAL_LOAD_IN_KG => self::INTEGER,
            RidingAnimalPropertyCode::DEFIANCE => self::INTEGER,
        ];
    }

    /**
     * @param RidingAnimalCode $ridingAnimalCode
     * @return int
     */
    public function getSpeed(RidingAnimalCode $ridingAnimalCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue([$ridingAnimalCode->getValue()], RidingAnimalPropertyCode::SPEED);
    }

    /**
     * @param RidingAnimalCode $ridingAnimalCode
     * @return int
     */
    public function getEndurance(RidingAnimalCode $ridingAnimalCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue([$ridingAnimalCode->getValue()], RidingAnimalPropertyCode::ENDURANCE);
    }

    /**
     * @param RidingAnimalCode $ridingAnimalCode
     * @return int
     */
    public function getMaximalLoad(RidingAnimalCode $ridingAnimalCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue([$ridingAnimalCode->getValue()], RidingAnimalPropertyCode::MAXIMAL_LOAD);
    }

    /**
     * @param RidingAnimalCode $ridingAnimalCode
     * @return int
     */
    public function getMaximalLoadInKg(RidingAnimalCode $ridingAnimalCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue([$ridingAnimalCode->getValue()], RidingAnimalPropertyCode::MAXIMAL_LOAD_IN_KG);
    }

    /**
     * @param RidingAnimalCode $ridingAnimalCode
     * @param bool $jumpingAndDangerousMoves
     * @return int
     */
    public function getDefianceOfDomesticated(
        RidingAnimalCode $ridingAnimalCode, $jumpingAndDangerousMoves)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return
            $this->getValue([$ridingAnimalCode->getValue()], RidingAnimalPropertyCode::DEFIANCE)
            + ($jumpingAndDangerousMoves ? 2 : 0);
    }

    /**
     * @param RidingAnimalCode $ridingAnimalCode
     * @param DefianceOfWildPercents $defianceOfWildPercents
     * @param bool $jumpingAndDangerousMoves
     * @return int
     */
    public function getDefianceOfWild(
        RidingAnimalCode $ridingAnimalCode,
        DefianceOfWildPercents $defianceOfWildPercents,
        $jumpingAndDangerousMoves
    )
    {
        $defianceOfDomesticated = $this->getDefianceOfDomesticated($ridingAnimalCode, $jumpingAndDangerousMoves);
        $additionForWild = SumAndRound::round(10 + (2 * $defianceOfWildPercents->getRate())); // 10..12

        return $defianceOfDomesticated + $additionForWild;
    }

}