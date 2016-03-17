<?php
namespace DrdPlus\Tables\Measurements\Parts;

use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Exceptions\BonusAlreadyPaired;
use DrdPlus\Tables\Measurements\Exceptions\DataFromFileAreCorrupted;
use DrdPlus\Tables\Measurements\Exceptions\DataRowsAreMissingInFile;
use DrdPlus\Tables\Measurements\Exceptions\FileCanNotBeRead;
use DrdPlus\Tables\Measurements\Exceptions\FileIsEmpty;
use DrdPlus\Tables\Measurements\Exceptions\UnexpectedChangeNotation;
use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\Tools\EvaluatorInterface;
use DrdPlus\Tables\Parts\AbstractTable;
use Granam\Float\Tools\ToFloat;

/**
 * Note: every file-table can create Bonus as well as Measurement
 */
abstract class AbstractFileTable extends AbstractTable
{

    /**
     * @var string[][]
     */
    private $indexedValues;
    /**
     * @var EvaluatorInterface
     */
    private $evaluator;

    public function __construct(EvaluatorInterface $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * @return \string[][]
     */
    public function getIndexedValues()
    {
        if (!isset($this->indexedValues)) {
            $this->loadData();
        }

        return $this->indexedValues;
    }

    protected function getRowsHeader()
    {
        return [
            ['bonus']
        ];
    }

    protected function getColumnsHeader()
    {
        return $this->getExpectedDataHeader();
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
     * @param int $bonusValue
     * @return AbstractBonus
     */
    abstract protected function createBonus($bonusValue);

    /**
     * @param float $value
     * @param string $unit
     *
     * @return MeasurementWithBonus
     */
    abstract protected function convertToMeasurement($value, $unit);

    /**
     * @return array
     */
    private function loadData()
    {
        $rawData = $this->fetchDataFromFile($this->getDataFileName());
        $indexed = $this->normalizeAndIndex($rawData);

        $this->indexedValues = $indexed;
    }

    private function fetchDataFromFile($dataSourceFile)
    {
        $resource = fopen($dataSourceFile, 'r');
        if (!$resource) {
            throw new FileCanNotBeRead("File with table data could not be read from $dataSourceFile");
        }
        $data = [];
        do {
            $row = fgetcsv($resource);
            if (count($row) > 0 && $row !== false) { // otherwise skipp empty row
                $data[] = $row;
            }
        } while (is_array($row));

        if (!$data) {
            throw new FileIsEmpty("No data have been read from $dataSourceFile");
        }

        return $data;
    }

    private function normalizeAndIndex(array $data)
    {
        $expectedHeader = array_merge(['bonus'], $this->getExpectedDataHeader());
        if (!isset($data[0]) || $data[0] !== $expectedHeader) {
            throw new DataFromFileAreCorrupted(
                'Data file is corrupted. Expected header with ' . implode(',', $expectedHeader)
            );
        }
        $indexed = [];
        unset($data[0]); // removing human header
        foreach ($data as $row) {
            if (!empty($row)) {
                $formattedRow = $this->formatRow($row, $expectedHeader);
                if (isset($indexed[key($formattedRow)])) {
                    throw new BonusAlreadyPaired(
                        'Bonus ' . key($formattedRow) . ' is already paired with value(s) ' . implode(',', $indexed[key($formattedRow)])
                        . ', got ' . implode(',', current($formattedRow))
                    );
                }
                $indexed[key($formattedRow)] = current($formattedRow);
            }
        }
        if (count($indexed) === 0) {
            throw new DataRowsAreMissingInFile("Data file is empty. Expected at least single row with values (header excluded)");
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
        return (int)$this->parseNumber($value);
    }

    private function parseNumber($value)
    {
        return str_replace(
            ['−' /* from ASCII 226 */, ','], // unified minus sign and float format (decimal delimiter)
            ['-' /* to ASCII 45 */, '.'],
            $value
        );
    }

    private function parseValue($value)
    {
        $value = trim($value);
        if ($value === '') {
            return $value;
        }
        if ($this->isItDiceRollChance($value)) { // dice chance bonus, like 1/6
            return $value;
        }

        return ToFloat::toFloat($this->parseNumber($value));
    }

    /**
     * @param $value
     *
     * @return int
     */
    private function isItDiceRollChance($value)
    {
        return preg_match('~^\d+/\d+$~', $value) > 0;
    }

    /**
     * @param AbstractBonus $bonus
     * @param string $wantedUnit
     *
     * @return MeasurementWithBonus
     */
    protected function toMeasurement(AbstractBonus $bonus, $wantedUnit = null)
    {
        $this->checkBonus($bonus);
        $bonusValue = $bonus->getValue();
        if (is_null($wantedUnit) && isset($this->getIndexedValues()[$bonusValue])) {
            $wantedUnit = key($this->getIndexedValues()[$bonusValue]);
        } else {
            $this->checkUnit($wantedUnit);
        }

        if (!isset($this->getIndexedValues()[$bonusValue][$wantedUnit])) {
            throw new Exceptions\MissingDataForBonus("Missing data for bonus $bonus with unit $wantedUnit");
        }
        $rawValue = $this->getIndexedValues()[$bonusValue][$wantedUnit];
        $wantedValue = $this->evaluate($rawValue);

        return $this->convertToMeasurement($wantedValue, $wantedUnit);
    }

    private function checkBonus(AbstractBonus $bonus)
    {
        if (!isset($this->getIndexedValues()[$bonus->getValue()])) {
            throw new Exceptions\MissingDataForBonus("Value to bonus $bonus is not defined.");
        }
    }

    protected function checkUnit($unit)
    {
        if (!in_array($unit, $this->getExpectedDataHeader(), true)) {
            throw new UnknownUnit(
                "Expected unit " . implode(',', $this->getExpectedDataHeader()) . ", got $unit"
            );
        }
    }

    /**
     * @param $rawValue
     *
     * @return float|int
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
        if (!isset($chanceParts[0]) || (int)$chanceParts[0] < 0 || (int)$chanceParts[0] > 6
            || (int)$chanceParts[1] !== 6
        ) {
            throw new UnexpectedChangeNotation("Expected only 0..6/6 chance, got $chance");
        }

        return (int)$chanceParts[0];
    }

    /**
     * @param MeasurementWithBonus $measurement
     *
     * @return AbstractBonus
     */
    protected function measurementToBonus(MeasurementWithBonus $measurement)
    {
        return $this->createBonus($this->determineBonus($measurement));
    }

    /**
     * @param MeasurementWithBonus $measurement
     *
     * @return int
     */
    private function determineBonus(MeasurementWithBonus $measurement)
    {
        $finds = $this->findBonusMatchingTo($measurement);
        if (is_int($finds)) {
            return $finds; // we found the bonus by value exact match
        }

        return $this->getBonusClosestTo($measurement->getValue(), $finds['lower'], $finds['higher']);
    }

    private function findBonusMatchingTo(MeasurementWithBonus $measurement)
    {
        $searchedValue = ToFloat::toFloat($measurement->getValue());
        $searchedUnit = $measurement->getUnit();
        $closest = ['lower' => [], 'higher' => []]; // value to bonuses
        foreach ($this->getIndexedValues() as $bonus => $relatedValues) {
            if (!array_key_exists($searchedUnit, $relatedValues)) { // current row doesn't have required unit
                continue;
            }
            $relatedValue = $relatedValues[$searchedUnit];
            if ($relatedValue === $searchedValue) {
                return $bonus; // we have found exact match
            }
            if ($this->isItDiceRollChance($relatedValue)) {
                continue; // dice roll chance fractions are skipped (example '2/6')
            }
            $stringRelatedValue = "$relatedValue"; // because PHP is silently converting float to int
            if ($searchedValue > $relatedValue) {
                if (count($closest['lower']) === 0 || key($closest['lower']) < $stringRelatedValue) {
                    $closest['lower'] = [$stringRelatedValue => [$bonus]]; // new value to [bonus] pair
                } else if (count($closest['lower']) > 0 && key($closest['lower']) === $stringRelatedValue) {
                    $closest['lower'][$stringRelatedValue][] = $bonus; // adding bonus for same value
                }
            } else if ($searchedValue < $relatedValue) {
                if (count($closest['higher']) === 0 || key($closest['higher']) > $stringRelatedValue) {
                    $closest['higher'] = [$stringRelatedValue => [$bonus]]; // new value to bonus pair
                } else if (count($closest['higher']) > 0 && key($closest['higher']) === $stringRelatedValue) {
                    $closest['higher'][$stringRelatedValue][] = $bonus; // adding bonus for same value
                }
            }
        }

        if (count($closest['lower']) === 0 || count($closest['higher']) === 0) {
            throw new Exceptions\RequestedDataOutOfTableRange(
                "Value $searchedValue (unit '$searchedUnit') is out of table values."
            );
        }

        return $closest;
    }

    /**
     * @param float $searchedValue
     * @param array $closestLower
     * @param array $closestHigher
     *
     * @return int
     */
    private function getBonusClosestTo($searchedValue, array $closestLower, array $closestHigher)
    {
        $searchedValue = ToFloat::toFloat($searchedValue);
        $closerValue = $this->getCloserValue($searchedValue, key($closestLower), key($closestHigher));
        if ($closerValue !== false) {
            if (array_key_exists($closerValue, $closestLower)) {
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

}
