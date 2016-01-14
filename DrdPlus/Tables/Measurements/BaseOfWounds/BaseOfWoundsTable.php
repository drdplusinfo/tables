<?php
namespace DrdPlus\Tables\Measurements\BaseOfWounds;

use DrdPlus\Tables\Table;
use Granam\Strict\Object\StrictObject;

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

                    return intval($number);
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
        $bonusToColumnRank = $this->transpose($axisX);

        return $bonusToColumnRank; // rank (index) starts by number 1
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

        $bonusToRowRank = $this->transpose($axisY);

        return $bonusToRowRank; // rank (index) starts by number 1
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

    public function getValues()
    {
        return $this->values;
    }

    public function sumBonuses(array $bonuses)
    {
        while (!is_null($firstBonus = array_shift($bonuses)) && !is_null($secondBonus = array_shift($bonuses))) {
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
     * @param array|int[] $bonuses
     *
     * @return int|null summarized bonuses, or null if no given (single bonus results into the same bonus)
     */
    public function getBonusesIntersection(array $bonuses)
    {
        while (!is_null($firstBonus = array_shift($bonuses)) && !is_null($secondBonus = array_shift($bonuses))) {
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
