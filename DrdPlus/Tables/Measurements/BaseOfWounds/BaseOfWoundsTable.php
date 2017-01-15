<?php
namespace DrdPlus\Tables\Measurements\BaseOfWounds;

use DrdPlus\Tables\Table;
use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;

/**
 * See PPH page 165 bottom, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_pro_vypocet_zz
 * Technical note: base of wounds is special table, without standard interface.
 */
class BaseOfWoundsTable extends StrictObject implements Table
{

    /**
     * @var array|string[][]
     */
    private $values;
    /**
     * @var array
     */
    private $bonuses;
    /**
     * @var array
     */
    private $axisX;
    /**
     * @var array
     */
    private $axisY;

    /**
     * @return array|null|\string[][]
     */
    public function getValues()
    {
        if ($this->values === null) {
            $this->loadValues();
        }

        return $this->values;
    }

    private function loadValues()
    {
        $this->values = $this->fetchData();
    }

    /**
     * @return array|string[][]
     */
    private function fetchData()
    {
        $data = [];
        $handle = fopen(__DIR__ . '/data/base_of_wounds.csv', 'rb');
        while ($row = fgetcsv($handle)) {
            $data[] = array_map(
                function ($value) {
                    $number = str_replace('−' /* ASCII 226 */, '-' /* ASCII 45 */, $value);

                    return is_numeric($number)
                        ? (int)$number
                        : $number; // the ⊕ sign
                },
                $row
            );
        }

        return $data;
    }

    /**
     * @param array|int[][] $data
     * @return array|int[]
     */
    private function collectAxisY(array $data)
    {
        $axisY = [];
        foreach ($data as $index => $row) {
            $axisY[$index] = $row[0]; // value from first column
        }
        unset ($axisY[0]); // removing blank first value ("⊕")

        return $this->transpose($axisY); // note: rank (index) starts by number 1
    }

    /**
     * @return array|null|\string[][]
     */
    public function getIndexedValues()
    {
        return $this->getValues();
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return [];
    }

    /**
     * If gets two bonuses to sum, returns "base of wounds" + 5 according to note about bonuses summation.
     * See note on PPH page 164, bottom.
     *
     * @param array|int|IntegerInterface[] $bonuses
     * @return int
     * @throws Exceptions\SumOfBonusesResultsIntoNull
     */
    public function sumBonuses(array $bonuses)
    {
        while (($firstBonus = array_shift($bonuses)) !== null && ($secondBonus = array_shift($bonuses)) !== null) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $firstBonus = ToInteger::toInteger($firstBonus);
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $secondBonus = ToInteger::toInteger($secondBonus);
            $intersection = $this->getBonusesIntersection([$firstBonus, $secondBonus]);
            $sum = $intersection + 5; // see note on PPH page 164, bottom
            if (count($bonuses) === 0) {
                return $sum;
            }
            array_unshift($bonuses, $sum);
        }

        if ($firstBonus !== null) {
            return $firstBonus; // the first if single bonus
        }

        throw new Exceptions\SumOfBonusesResultsIntoNull('Sum of ' . count($bonuses) . ' bonuses resulted into NULL');
    }

    /**
     * Warning - the result depends on the SEQUENCE of given bonuses.
     *
     * @param array|int[]|IntegerInterface[] $bonuses
     * @return int summarized bonuses
     * @throws \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\SumOfBonusesResultsIntoNull
     * @throws \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\BonusToIntersectIsOutOfKnownValues
     */
    public function getBonusesIntersection(array $bonuses)
    {
        while (($firstBonus = array_shift($bonuses)) !== null && ($secondBonus = array_shift($bonuses)) !== null) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $firstBonus = ToInteger::toInteger($firstBonus);
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $secondBonus = ToInteger::toInteger($secondBonus);
            $columnRank = $this->getColumnRank($firstBonus);
            $rowRank = $this->getRowRank($secondBonus);
            $sumBonus = $this->locateBonus($columnRank, $rowRank);
            if (count($bonuses) === 0) { // noting more to count
                return $sumBonus;
            }
            // warning - the result is dependent on the sequence of bonuses
            array_unshift($bonuses, $sumBonus); // add the sum to the beginning and run another sum-iteration
        }
        if ($firstBonus !== null) {
            return $firstBonus; // the first if single bonus
        }

        throw new Exceptions\SumOfBonusesResultsIntoNull('Sum of ' . count($bonuses) . ' bonuses resulted into NULL');
    }

    /**
     * @param int $bonus
     * @return int
     * @throws \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\BonusToIntersectIsOutOfKnownValues
     */
    private function getColumnRank($bonus)
    {
        if (array_key_exists($bonus, $this->getAxisX())) {
            return $this->getAxisX()[$bonus];
        }
        throw new Exceptions\BonusToIntersectIsOutOfKnownValues(
            "Can not intersect bonus of value {$bonus} because it is out of table values"
        );
    }

    /**
     * @return array|int[]
     */
    private function getAxisX()
    {
        if ($this->axisX === null) {
            $this->axisX = $this->collectAxisX($this->getValues());
        }

        return $this->axisX;
    }

    /**
     * @param array|int[][] $data
     * @return array|int[][]
     */
    private function collectAxisX(array $data)
    {
        $axisX = $data[0]; // first row
        unset($axisX[0]); // removing blank first value ("⊕")

        return $this->transpose($axisX); // note: rank (index) starts by number 1
    }

    /**
     * @param array $data
     * @return array
     */
    private function transpose(array $data)
    {
        return array_flip($data);
    }

    /**
     * @param int $bonus
     * @return int
     * @throws \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\BonusToIntersectIsOutOfKnownValues
     */
    private function getRowRank($bonus)
    {
        if (array_key_exists($bonus, $this->getAxisY())) {
            return $this->getAxisY()[$bonus];
        }
        throw new Exceptions\BonusToIntersectIsOutOfKnownValues(
            "Can not intersect bonus of value {$bonus} because it is out of table values"
        );
    }

    /**
     * @return array|int[]
     */
    private function getAxisY()
    {
        if ($this->axisY === null) {
            $this->axisY = $this->collectAxisY($this->values);
        }

        return $this->axisY;
    }

    /**
     * @param int $columnRank
     * @param int $rowRank
     * @return int
     */
    private function locateBonus($columnRank, $rowRank)
    {
        return $this->getBonuses()[$rowRank][$columnRank];
    }

    /**
     * @return array
     */
    private function getBonuses()
    {
        if ($this->bonuses === null) {
            $this->bonuses = $this->collectBonuses($this->values);
        }

        return $this->bonuses;
    }

    /**
     * @param array|int[][] $data
     * @return array|int[][]
     */
    private function collectBonuses(array $data)
    {
        unset($data[0]); // removing first row - the axis X header
        $rankedBonuses = [];
        foreach ($data as $rowRank => $row) {
            unset($row[0]); // removing first column - the axis Y header
            $rankedBonuses[$rowRank] = $row;
        }

        return $rankedBonuses; // indexed as row index => column index => bonus
    }

    /**
     * @param int|IntegerInterface $rowIndex
     * @param int|IntegerInterface $columnIndex
     * @return string
     * @throws Exceptions\NoRowExistsOnProvidedIndex
     * @throws Exceptions\NoColumnExistsOnProvidedIndex
     */
    public function getValue($rowIndex, $columnIndex)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $integerRowIndex = ToInteger::toInteger($rowIndex);
        if (!array_key_exists($integerRowIndex, $this->getValues())) {
            throw new Exceptions\NoRowExistsOnProvidedIndex(
                'No row exists for given row index ' . ValueDescriber::describe($rowIndex)
            );
        }
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $integerColumnIndex = ToInteger::toInteger($columnIndex);
        if (!array_key_exists($integerColumnIndex, $this->getValues()[$integerRowIndex])) {
            throw new Exceptions\NoColumnExistsOnProvidedIndex(
                'No column exists for given column index ' . ValueDescriber::describe($columnIndex)
            );
        }

        return $this->getValues()[$integerRowIndex][$integerColumnIndex];
    }

    /**
     * @param int|IntegerInterface $strength
     * @param int|IntegerInterface $weaponBaseOfWounds
     * @return int
     * @throws Exceptions\SumOfBonusesResultsIntoNull
     */
    public function calculateBaseOfWounds($strength, $weaponBaseOfWounds)
    {
        return $this->getBonusesIntersection([$strength, $weaponBaseOfWounds]);
    }

    /**
     * @param int|IntegerInterface $bonus
     * @return int
     */
    public function halfBonus($bonus)
    {
        // see PPH page 72, left column
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return ToInteger::toInteger($bonus) - 6;
    }

    /**
     * @param int|IntegerInterface $bonus
     * @return int
     */
    public function doubleBonus($bonus)
    {
        // see PPH page 72, left column
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return ToInteger::toInteger($bonus) + 6;
    }

    /**
     * @param int|IntegerInterface $bonus
     * @return int
     */
    public function tenMultipleBonus($bonus)
    {
        // see PPH page 72, left column
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return ToInteger::toInteger($bonus) + 20;
    }

    /**
     * @param int|IntegerInterface $bonus
     * @return int
     */
    public function tenMinifyBonus($bonus)
    {
        // see PPH page 72, left column
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return ToInteger::toInteger($bonus) - 20;
    }

}