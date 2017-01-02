<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\RaceCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

class SightRangesTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/sight_ranges.csv';
    }

    const MAXIMAL_LIGHTING = 'maximal_lighting';
    const MINIMAL_LIGHTING = 'minimal_lighting';
    const ADAPTABILITY = 'adaptability';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::MAXIMAL_LIGHTING => self::INTEGER,
            self::MINIMAL_LIGHTING => self::INTEGER,
            self::ADAPTABILITY => self::POSITIVE_INTEGER,
        ];
    }

    const RACE = 'race';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [
            self::RACE,
        ];
    }

    /**
     * @param RaceCode $raceCode
     * @return int
     */
    public function getMaximalLighting(RaceCode $raceCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($raceCode, self::MAXIMAL_LIGHTING);
    }

    /**
     * @param RaceCode $raceCode
     * @return int
     */
    public function getMinimalLighting(RaceCode $raceCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($raceCode, self::MINIMAL_LIGHTING);
    }

    /**
     * @param RaceCode $raceCode
     * @return int
     */
    public function getAdaptability(RaceCode $raceCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($raceCode, self::ADAPTABILITY);
    }

}