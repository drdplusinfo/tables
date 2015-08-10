<?php
namespace DrdPlus\Tables;

use Granam\Float\Tools\ToFloat;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;

abstract class AbstractTable extends StrictObject implements TableInterface
{

    /**
     * @var string[][]
     */
    private $data;
    /**
     * @var EvaluatorInterface
     */
    private $evaluator;

    public function __construct(EvaluatorInterface $evaluator)
    {
        $this->data = $this->fetchData();
        $this->evaluator = $evaluator;
    }

    /**
     * @return array
     */
    private function fetchData()
    {
        $rawData = $this->fetchFromFile($this->getDataFileName());
        $indexed = $this->indexData($rawData);

        return $indexed;
    }

    private function fetchFromFile($dataSourceFile)
    {
        $resource = fopen($dataSourceFile, 'r');
        if (!$resource) {
            throw new \RuntimeException("File with table data could not be read from $dataSourceFile");
        }
        $data = [];
        do {
            $row = fgetcsv($resource);
            if (count($row) > 0 && $row !== false) { // otherwise skipp empty row
                $data[] = $row;
            }
        } while (is_array($row));

        if (!$data) {
            throw new \RuntimeException("No data have been read from $dataSourceFile");
        }

        return $data;
    }

    private function indexData(array $data)
    {
        $expectedHeader = array_merge(['bonus'], $this->getExpectedDataHeader());
        if (!isset($data[0]) || $data[0] !== $expectedHeader) {
            throw new \RuntimeException('Data file is corrupted. Expected header with values ' . implode(',', $expectedHeader));
        }
        $indexed = [];
        unset($data[0]); // removing human header
        foreach ($data as $row) {
            if (!empty($row)) {
                $formattedRow = $this->formatRow($row, $expectedHeader);
                $indexed[key($formattedRow)] = current($formattedRow);
            }
        }
        if (count($indexed) === 0) {
            throw new \RuntimeException("Data file is empty. Expected at least single row with values (header excluded)");
        }

        return $indexed;
    }

    private function formatRow(array $row, array $expectedHeader)
    {
        $indexedValues = array_combine($expectedHeader, $row);
        $bonus = $this->parseBonus($indexedValues['bonus']);
        unset($indexedValues['bonus']); // left values only
        $indexedRow = [$bonus => []];
        foreach ($indexedValues as $index => $value) {
            $value = $this->parseValue($value);
            if ($value === '') { // skipping empty value
                continue;
            }
            $indexedRow[$bonus][$index] = $value;
        }

        return $indexedRow;
    }

    private function parseBonus($value)
    {
        return intval($this->parseNumber($value));
    }

    private function parseNumber($value)
    {
        return str_replace('−' /* ASCII 226 */, '-' /* ASCII 45 */, $value);
    }

    private function parseValue($value)
    {
        $value = trim($value);
        if ($value === '') {
            return $value;
        }
        if ($this->isDiceRollChance($value)) { // dice chance bonus, like 1/6
            return $value;
        }

        return ToFloat::toFloat($this->parseNumber($value));
    }

    /**
     * @param $value
     *
     * @return int
     */
    private function isDiceRollChance($value)
    {
        return preg_match('~^\d+/\d+$~', $value);
    }

    /**
     * @return \string[]
     */
    abstract protected function getExpectedDataHeader();

    /**
     * @return string
     */
    abstract protected function getDataFileName();

    /**
     * @param int $bonus
     * @param string $wantedUnit
     *
     * @return MeasurementInterface
     */
    public function toMeasurement($bonus, $wantedUnit = null)
    {
        $bonus = $this->convertToInteger($bonus);
        $this->checkBonus($bonus);
        if (is_null($wantedUnit) && isset($this->data[$bonus])) {
            $wantedUnit = key($this->data[$bonus]);
        } else {
            $this->checkUnit($wantedUnit);
        }

        if (isset($this->data[$bonus][$wantedUnit])) {
            $rawValues = $this->data[$bonus];
            $values = [];
            foreach ($rawValues as $unit => $rawValue) {
                $values[$unit] = $this->evaluate($rawValue);
            }
            $wantedValue = $values[$wantedUnit];
            $measurement = $this->convertToMeasurement($wantedValue, $wantedUnit);
            unset($values[$wantedUnit]);
            foreach ($values as $anotherUnit => $anotherValue) {
                $measurement->addInDifferentUnit($anotherValue, $anotherUnit);
            }

            return $measurement;
        }

        throw new \LogicException(
            "Missing data for bonus $bonus and expected data columns " . implode(',', $this->getExpectedDataHeader())
        );
    }

    protected function convertToInteger($value)
    {
        return ToInteger::toInteger($value);
    }

    private function checkBonus($bonus)
    {
        if (!isset($this->data[$bonus])) {
            throw new \OutOfRangeException("Value to bonus $bonus is not defined.");
        }
    }

    private function checkUnit($unit)
    {
        if (!in_array($unit, $this->getExpectedDataHeader())) {
            throw new Exceptions\UnknownUnit(
                "Expected unit " . implode(',', $this->getExpectedDataHeader()) . ", got $unit"
            );
        }
    }

    /**
     * @param $rawValue
     *
     * @return int
     */
    private function evaluate($rawValue)
    {
        if (is_float($rawValue)) {
            return $rawValue;
        }

        return $this->evaluator->evaluate($this->parseMaxRollToGetValue($rawValue));
    }

    /**
     * @param string $chance
     *
     * @return int
     */
    private function parseMaxRollToGetValue($chance)
    {
        $chanceParts = explode('/', $chance);
        if (!isset($chanceParts[1]) || intval($chanceParts[1]) !== 6) {
            throw new \LogicException("Expected only x/6 chance, got $chance");
        }

        return intval([0]);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return MeasurementInterface
     */
    abstract protected function convertToMeasurement($value, $unit);

    /**
     * @param MeasurementInterface $measurement
     *
     * @return int
     */
    public function toBonus(MeasurementInterface $measurement)
    {
        $searchedUnit = $measurement->getUnit();
        $searchedValue = ToFloat::toFloat($this->parseNumber($measurement->getValue()));
        $finds = $this->findBonusMatchingTo($searchedValue, $searchedUnit);
        if (is_int($finds)) {
            return $finds; // we found the bonus by value exact match
        }

        return $this->getBonusClosestTo($searchedValue, $finds['lower'], $finds['higher']);
    }

    private function findBonusMatchingTo($searchedValue, $searchedUnit)
    {
        $closest = ['lower' => [], 'higher' => []];
        foreach ($this->getData() as $bonus => $relatedValues) {
            if (!isset($relatedValues[$searchedUnit])) { // current row doesn't have required unit
                continue;
            }
            $relatedValue = $relatedValues[$searchedUnit];
            if ($relatedValue === $searchedValue) {
                return $bonus; // we found exact match
            }
            if ($searchedValue > $relatedValue) {
                if (empty($closest['lower']) || key($closest['lower']) < $relatedValue) {
                    $closest['lower'] = [$relatedValue => [$bonus]]; // new value to [bonus] pair
                } else if (!empty($closest['lower']) && key($closest['lower']) === $relatedValue) {
                    $closest['lower'][$relatedValue][] = $bonus; // adding bonus for same value
                }
            }
            if ($searchedValue < $relatedValue) {
                if (empty($closest['higher']) || key($closest['higher']) > $relatedValue) {
                    $closest['higher'] = [$relatedValue => [$bonus]]; // new value to bonus pair
                } else if (!empty($closest['higher']) && key($closest['higher']) === $relatedValue) {
                    $closest['higher'][$relatedValue][] = $bonus; // adding bonus for same value
                }
            }
        }

        if (count($closest['lower']) === 0 || count($closest['higher']) === 0) {
            throw new \OutOfRangeException("Value $searchedValue($searchedUnit) is out of table values.");
        }

        return $closest;
    }

    private function getBonusClosestTo($searchedValue, array $closestLower, $closestHigher)
    {
        $closerValue = $this->getCloserValue($searchedValue, key($closestLower), key($closestHigher));
        if ($closerValue !== false) {
            if (isset($closestLower[$closerValue])) {
                $bonuses = $closestLower[$closerValue];
            } else {
                $bonuses = $closestHigher[$closerValue];
            }

            // matched single table-value, maybe with more bonuses, the lowest bonus should be taken
            return min($bonuses); // PPH page 11, right column
        } else {
            // both table border-values are equally close to the value, we will choose from bonuses of both borders
            $bonuses = array_merge(
                count($closestLower) > 0
                    ? current($closestLower)
                    : []
                ,
                count($closestHigher) > 0
                    ? current($closestHigher)
                    : []
            );

            // matched two table-values, more bonuses for sure, the highest bonus should be taken
            return max($bonuses); // PPH page 11, right column
        }
    }

    private function getCloserValue($toValue, $firstValue, $secondValue)
    {
        $firstDifference = $toValue - $firstValue;
        $secondDifference = $toValue - $secondValue;
        if (abs($firstDifference) < abs($secondDifference)) {
            return $firstValue;
        }
        if (abs($secondDifference) < abs($firstDifference)) {
            return $secondValue;
        }

        return false; // differences are equal
    }

    /**
     * @return \string[]
     */
    protected function getData()
    {
        return $this->data;
    }
}
