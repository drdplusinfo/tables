<?php
namespace DrdPlus\Tables\Measurements\Partials;

use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Exceptions\BonusAlreadyPaired;
use DrdPlus\Tables\Measurements\Exceptions\DataFromFileAreCorrupted;
use DrdPlus\Tables\Measurements\Exceptions\DataRowsAreMissingInFile;
use DrdPlus\Tables\Measurements\Exceptions\FileCanNotBeRead;
use DrdPlus\Tables\Measurements\Exceptions\FileIsEmpty;
use DrdPlus\Tables\Measurements\Exceptions\UnexpectedChanceNotation;
use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\Tools\EvaluatorInterface;
use DrdPlus\Tables\Partials\AbstractTable;
use Granam\Float\Tools\ToFloat;
use Granam\Integer\Tools\ToInteger;

/**
 * Note: every file-table can create Bonus as well as Measurement
 */
abstract class AbstractMeasurementFileTable extends AbstractTable
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
     * @return string[][]
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\LoadingDataFailed
     */
    public function getIndexedValues()
    {
        if ($this->indexedValues === null) {
            try {
                $this->loadData();
            } catch (\DrdPlus\Tables\Measurements\Exceptions\Exception $loadingException) {
                throw new Exceptions\LoadingDataFailed(
                    $loadingException->getMessage(), $loadingException->getCode(), $loadingException
                );
            }
        }

        return $this->indexedValues;
    }

    /**
     * @return array|string[][]
     */
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
     * @throws \DrdPlus\Tables\Measurements\Exceptions\FileCanNotBeRead
     * @throws \DrdPlus\Tables\Measurements\Exceptions\FileIsEmpty
     * @throws \DrdPlus\Tables\Measurements\Exceptions\DataFromFileAreCorrupted
     * @throws \DrdPlus\Tables\Measurements\Exceptions\BonusAlreadyPaired
     * @throws \DrdPlus\Tables\Measurements\Exceptions\DataRowsAreMissingInFile
     */
    private function loadData()
    {
        $rawData = $this->fetchDataFromFile($this->getDataFileName());
        $indexed = $this->normalizeAndIndex($rawData);
        $this->indexedValues = $indexed;
    }

    /**
     * @param $dataSourceFile
     * @return array
     * @throws \DrdPlus\Tables\Measurements\Exceptions\FileCanNotBeRead
     * @throws \DrdPlus\Tables\Measurements\Exceptions\FileIsEmpty
     */
    private function fetchDataFromFile($dataSourceFile)
    {
        $resource = fopen($dataSourceFile, 'rb');
        if (!$resource) {
            throw new FileCanNotBeRead("File with table data could not be read from $dataSourceFile");
        }
        $data = [];
        do {
            $row = fgetcsv($resource);
            if ($row !== false && count($row)) { // otherwise skipp empty row
                $data[] = $row;
            }
        } while (is_array($row));

        if (!$data) {
            throw new FileIsEmpty("No data have been read from $dataSourceFile");
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     * @throws \DrdPlus\Tables\Measurements\Exceptions\DataFromFileAreCorrupted
     * @throws \DrdPlus\Tables\Measurements\Exceptions\BonusAlreadyPaired
     * @throws \DrdPlus\Tables\Measurements\Exceptions\DataRowsAreMissingInFile
     */
    private function normalizeAndIndex(array $data)
    {
        $expectedHeader = array_merge(['bonus'], $this->getExpectedDataHeader());
        if (!array_key_exists(0, $data) || $data[0] !== $expectedHeader) {
            throw new DataFromFileAreCorrupted(
                'Data file is corrupted. Expected header with ' . implode(',', $expectedHeader)
            );
        }
        $indexed = [];
        unset($data[0]); // removing human header
        foreach ($data as $row) {
            if (count($row) > 0) {
                $formattedRow = $this->formatRow($row, $expectedHeader);
                if (array_key_exists(key($formattedRow), $indexed)) {
                    throw new BonusAlreadyPaired(
                        'Bonus ' . key($formattedRow) . ' is already paired with value(s) ' . implode(',', $indexed[key($formattedRow)])
                        . ', got ' . implode(',', current($formattedRow))
                    );
                }
                $indexed[key($formattedRow)] = current($formattedRow);
            }
        }
        if (count($indexed) === 0) {
            throw new DataRowsAreMissingInFile(
                'Data file is empty. Expected at least single row with values (header excluded)'
            );
        }

        return $indexed;
    }

    /**
     * @param array|string[] $row
     * @param array|string[] $expectedHeader
     * @return array|string[]
     * @throws \DrdPlus\Tables\Measurements\Exceptions\DataFromFileAreCorrupted
     */
    private function formatRow(array $row, array $expectedHeader)
    {
        $indexedValues = array_combine($expectedHeader, $row);
        try {
            $bonus = $this->parseBonus($indexedValues['bonus']);
            unset($indexedValues['bonus']); // left values only
            $indexedRow = [$bonus => []];
            foreach ($indexedValues as $index => $value) {
                $value = $this->parseValue($value);
                if ($value === false) { // skipping empty value
                    continue;
                }
                $indexedRow[$bonus][$index] = $value;
            }
        } catch (\Granam\Number\Tools\Exceptions\Exception $conversionException) {
            throw new DataFromFileAreCorrupted(
                $conversionException->getMessage(), $conversionException->getCode(), $conversionException
            );
        }

        return $indexedRow;
    }

    /**
     * @param $value
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function parseBonus($value)
    {
        return ToInteger::toInteger($this->parseNumber($value));
    }

    /**
     * @param $value
     * @return string
     */
    private function parseNumber($value)
    {
        return str_replace(
            ['−' /* from ASCII 226 */, ','], // unified minus sign and float format (decimal delimiter)
            ['-' /* to ASCII 45 */, '.'],
            $value
        );
    }

    /**
     * @param $value
     * @return bool|float|string
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    private function parseValue($value)
    {
        $value = trim($value);
        if ($value === '') {
            return false;
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
     * @param string|null $wantedUnit
     * @return MeasurementWithBonus
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnexpectedChanceNotation
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\LoadingDataFailed
     */
    protected function toMeasurement(AbstractBonus $bonus, $wantedUnit = null)
    {
        $bonusValue = $bonus->getValue();
        $this->checkBonusExistence($bonusValue);
        $wantedUnit = $this->determineUnit($wantedUnit, $bonusValue);
        $rawValue = $this->getIndexedValues()[$bonusValue][$wantedUnit];
        $wantedValue = $this->evaluate($rawValue);

        return $this->convertToMeasurement($wantedValue, $wantedUnit);
    }

    private function checkBonusExistence($bonusValue)
    {
        if (!array_key_exists($bonusValue, $this->getIndexedValues())) {
            throw new Exceptions\UnknownBonus("Value to bonus {$bonusValue} is not defined.");
        }
    }

    /**
     * @param string|null $wantedUnit
     * @param int $bonusValue
     * @return mixed
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\LoadingDataFailed
     */
    private function determineUnit($wantedUnit, $bonusValue)
    {
        if ($wantedUnit === null) {
            $this->checkBonusExistence($bonusValue);
            $wantedUnit = key($this->getIndexedValues()[$bonusValue]);
        } else {
            $this->checkUnitExistence($wantedUnit);
        }

        return $wantedUnit;
    }

    protected function checkUnitExistence($unit)
    {
        if (!in_array($unit, $this->getExpectedDataHeader(), true)) {
            throw new UnknownUnit(
                'Expected one of units ' . implode(',', $this->getExpectedDataHeader()) . ", got $unit"
            );
        }
    }

    /**
     * @param $bonusValue
     * @param $wantedUnit
     * @return bool
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\LoadingDataFailed
     */
    private function hasValueByBonusValueAndUnit($bonusValue, $wantedUnit)
    {
        return
            array_key_exists($bonusValue, $this->getIndexedValues())
            && array_key_exists($wantedUnit, $this->getIndexedValues()[$bonusValue]);
    }

    /**
     * @param $rawValue
     * @return float|int
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnexpectedChanceNotation
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
     * @return int
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnexpectedChanceNotation
     */
    private function parseMaxRollToGetValue($chance)
    {
        $chanceParts = explode('/', $chance);
        if (!array_key_exists(0, $chanceParts) || !array_key_exists(1, $chanceParts) || (int)$chanceParts[0] < 0 || (int)$chanceParts[0] > 6
            || (int)$chanceParts[1] !== 6
        ) {
            throw new UnexpectedChanceNotation("Expected only 0..6/6 chance, got $chance");
        }

        return (int)$chanceParts[0];
    }

    /**
     * @param AbstractBonus $bonus
     * @param string|null $wantedUnit
     * @return bool
     */
    protected function hasMeasurementFor(AbstractBonus $bonus, $wantedUnit = null)
    {
        $bonusValue = $bonus->getValue();
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $wantedUnit = $this->determineUnit($wantedUnit, $bonusValue);

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->hasValueByBonusValueAndUnit($bonusValue, $wantedUnit);
    }

    /**
     * @param MeasurementWithBonus $measurement
     * @return AbstractBonus
     */
    protected function measurementToBonus(MeasurementWithBonus $measurement)
    {
        return $this->createBonus($this->determineBonusValue($measurement));
    }

    /**
     * @param MeasurementWithBonus $measurement
     *
     * @return int
     */
    private function determineBonusValue(MeasurementWithBonus $measurement)
    {
        $finds = $this->getBonusMatchingOrClosestTo($measurement);
        if (is_int($finds)) {
            return $finds; // we found the bonus by value exact match
        }

        return $this->getBonusClosestTo($measurement->getValue(), $finds['lower'], $finds['higher']);
    }

    private function getBonusMatchingOrClosestTo(MeasurementWithBonus $measurement)
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
     * @return int
     */
    private function getBonusClosestTo($searchedValue, array $closestLower, array $closestHigher)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $searchedValue = ToFloat::toFloat($searchedValue);
        $closerValue = $this->getCloserValue($searchedValue, key($closestLower), key($closestHigher));
        if ($closerValue !== false) {
            if (array_key_exists("$closerValue", $closestLower)) {
                $bonuses = $closestLower["$closerValue"];
            } else {
                $bonuses = $closestHigher["$closerValue"];
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

    /**
     * @param $toValue
     * @param $firstValue
     * @param $secondValue
     * @return bool|int|float|string
     */
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
