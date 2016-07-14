<?php
namespace DrdPlus\Tables\Equipment\Riding;

use DrdPlus\Codes\RidingAnimalCode;
use DrdPlus\Codes\RidingAnimalPropertyCode;
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

    protected function getExpectedRowsHeader()
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
     * @param Ride $ride
     * @param bool $jumpingAndDangerousMoves
     * @return int
     */
    public function getDefianceOfDomesticatedFor(
        RidingAnimalCode $ridingAnimalCode,
        Ride $ride,
        $jumpingAndDangerousMoves
    )
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return
            $this->getValue([$ridingAnimalCode->getValue()], RidingAnimalPropertyCode::DEFIANCE)
            + $ride->getValue()
            + ($jumpingAndDangerousMoves ? 2 : 0);
    }

    /**
     * @param RidingAnimalCode $ridingAnimalCode
     * @param DefianceOfWildPercents $defianceOfWildPercents
     * @param Ride $ride
     * @param bool $jumpingAndDangerousMoves
     * @return int
     */
    public function getDefianceOfWildFor(
        RidingAnimalCode $ridingAnimalCode,
        DefianceOfWildPercents $defianceOfWildPercents,
        Ride $ride,
        $jumpingAndDangerousMoves
    )
    {
        $defianceOfDomesticated = $this->getDefianceOfDomesticatedFor($ridingAnimalCode, $ride, $jumpingAndDangerousMoves);
        $additionForWild = 10 + SumAndRound::round($defianceOfWildPercents->getRate() * 2);

        return $defianceOfDomesticated + $additionForWild;
    }

}