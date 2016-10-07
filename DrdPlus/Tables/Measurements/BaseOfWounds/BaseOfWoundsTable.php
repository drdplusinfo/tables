<?php
namespace DrdPlus\Tables\Measurements\BaseOfWounds;

use DrdPlus\Tables\Table;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;

/**
 * Base of wounds is special table, without standard interface
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

    public function __construct()
    {
        $this->values = $this->loadData();
        $this->axisX = $this->collectAxisX($this->values);
        $this->axisY = $this->collectAxisY($this->values);
        $this->bonuses = $this->collectBonuses($this->values);
    }

    private function loadData()
    {
        $data = [];
        $handle = fopen(__DIR__ . '/data/base_of_wounds.csv', 'r');
        while ($row = fgetcsv($handle)) {
            $data[] = array_map(
                function ($value) {
                    $number = str_replace('−' /* ASCII 226 */, '-' /* ASCII 45 */, $value);

                    return is_numeric($number)
                        ? (int)$number
                        : $number;
                },
                $row
            );
        }

        return $data;
    }

    private function collectAxisX(array $data)
    {
        $axisX = $data[0]; // first row
        unset($axisX[0]); // removing blank first value ("⊕")

        return $this->transpose($axisX); // rank (index) starts by number 1
    }

    private function transpose(array $data)
    {
        return array_flip($data);
    }

    private function collectAxisY(array $data)
    {
        $axisY = [];
        foreach ($data as $index => $row) {
            $axisY[$index] = $row[0]; // value from first column
        }
        unset ($axisY[0]); // removing blank first value ("⊕")

        return $this->transpose($axisY); // rank (index) starts by number 1
    }

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

    public function getIndexedValues()
    {
        return $this->values;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getHeader()
    {
        return [];
    }

    /**
     * If gets two bonuses to sum, returns "base of wounds" + 5 according to note about bonuses summation.
     * See note on PPH page 164, bottom.
     *
     * @param array|int $bonuses
     * @return int|null
     */
    public function sumBonuses(array $bonuses)
    {
        while (($firstBonus = array_shift($bonuses)) !== null && ($secondBonus = array_shift($bonuses)) !== null) {
            $intersection = $this->getBonusesIntersection([$firstBonus, $secondBonus]);
            $sum = $intersection + 5; // see note on PPH page 164, bottom
            if (count($bonuses) === 0) {
                return $sum;
            }
            array_unshift($bonuses, $sum);
        }

        return $firstBonus; // the first if single bonus, or null, if no given
    }

    /**
     * Warning - the result depends on the sequence of bonuses
     *
     * @param array|int[] $bonuses
     * @return int|null summarized bonuses, or null if no given at all (empty array).
     */
    public function getBonusesIntersection(array $bonuses)
    {
        while (($firstBonus = array_shift($bonuses)) !== null && ($secondBonus = array_shift($bonuses)) !== null) {
            $columnRank = $this->getColumnRank($firstBonus);
            $rowRank = $this->getRowRank($secondBonus);
            $sumBonus = $this->locateBonus($columnRank, $rowRank);
            if (count($bonuses) === 0) { // noting more to count
                return $sumBonus;
            }
            // warning - the result is dependent on the sequence of bonuses
            array_unshift($bonuses, $sumBonus); // else add the sum to the beginning and run another sum-iteration
        }

        return $firstBonus; // the first if single bonus, or null, if no given
    }

    private function getColumnRank($bonus)
    {
        return $this->axisX[$bonus];
    }

    private function getRowRank($bonus)
    {
        return $this->axisY[$bonus];
    }

    private function locateBonus($columnRank, $rowRank)
    {
        return $this->bonuses[$rowRank][$columnRank];
    }

    /**
     * @param int $rowIndex
     * @param int $columnIndex
     * @return string
     * @throws Exceptions\NoRowExistsOnProvidedIndex
     * @throws Exceptions\NoColumnExistsOnProvidedIndex
     */
    public function getValue($rowIndex, $columnIndex)
    {
        if (!array_key_exists($rowIndex, $this->values)) {
            throw new Exceptions\NoRowExistsOnProvidedIndex(
                'No row exists for given row index ' . ValueDescriber::describe($rowIndex)
            );
        }
        if (!array_key_exists($columnIndex, $this->values[$rowIndex])) {
            throw new Exceptions\NoColumnExistsOnProvidedIndex(
                'No column exists for given column index ' . ValueDescriber::describe($columnIndex)
            );
        }

        return $this->values[$rowIndex][$columnIndex];
    }

    /**
     * @param int $strength
     * @param int $weaponBaseOfWounds
     *
     * @return int
     */
    public function calculateBaseOfWounds($strength, $weaponBaseOfWounds)
    {
        return $this->getBonusesIntersection([$strength, $weaponBaseOfWounds]);
    }

    /**
     * @param int $bonus
     *
     * @return mixed
     */
    public function halfBonus($bonus)
    {
        // see PPH page 72, left column
        return $bonus - 6;
    }

    /**
     * @param int $bonus
     *
     * @return mixed
     */
    public function doubleBonus($bonus)
    {
        // see PPH page 72, left column
        return $bonus + 6;
    }

    /**
     * @param int $bonus
     *
     * @return mixed
     */
    public function tenMultipleBonus($bonus)
    {
        // see PPH page 72, left column
        return $bonus + 20;
    }

    /**
     * @param int $bonus
     *
     * @return mixed
     */
    public function tenMinifyBonus($bonus)
    {
        // see PPH page 72, left column
        return $bonus - 20;
    }

}