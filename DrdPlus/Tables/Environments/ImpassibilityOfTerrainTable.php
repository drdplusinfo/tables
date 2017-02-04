<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Codes\Environment\TerrainCode;
use DrdPlus\Tables\Measurements\Speed\SpeedBonus;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use DrdPlus\Calculations\SumAndRound;
use Granam\Scalar\Tools\Exceptions\WrongParameterType;
use Granam\Tools\ValueDescriber;

/**
 * See PPH page 113 right column top, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_neschudnosti_terenu
 */
class ImpassibilityOfTerrainTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/impassibility_of_terrain.csv';
    }

    const TERRAIN = 'terrain';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::TERRAIN];
    }

    const IMPASSIBILITY_OF_TERRAIN_FROM = 'impassibility_of_terrain_from';
    const IMPASSIBILITY_OF_TERRAIN_TO = 'impassibility_of_terrain_to';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::IMPASSIBILITY_OF_TERRAIN_FROM => self::INTEGER,
            self::IMPASSIBILITY_OF_TERRAIN_TO => self::INTEGER,
        ];
    }

    /**
     * @param TerrainCode $terrainCode
     * @param SpeedTable $speedTable
     * @param TerrainDifficultyPercents $difficultyPercents
     * @return SpeedBonus
     * @throws \DrdPlus\Tables\Environments\Exceptions\UnknownTerrainCode
     * @throws \DrdPlus\Tables\Environments\Exceptions\InvalidTerrainCodeFormat
     */
    public function getSpeedMalusOnTerrain(
        TerrainCode $terrainCode,
        SpeedTable $speedTable,
        TerrainDifficultyPercents $difficultyPercents
    )
    {
        // value is zero or negative, so bonus is malus in fact
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new SpeedBonus($this->getSpeedMalusValueForTerrain($terrainCode, $difficultyPercents), $speedTable);
    }

    /**
     * @param TerrainCode $terrainCode
     * @param TerrainDifficultyPercents $difficultyPercents
     * @return int
     * @throws \DrdPlus\Tables\Environments\Exceptions\UnknownTerrainCode
     * @throws \DrdPlus\Tables\Environments\Exceptions\InvalidTerrainCodeFormat
     */
    private function getSpeedMalusValueForTerrain(
        TerrainCode $terrainCode,
        TerrainDifficultyPercents $difficultyPercents
    )
    {
        // value is zero or negative, so bonus is malus in fact
        $range = $this->getSpeedMalusValuesRangeForTerrain($terrainCode);
        $difference = $range[self::IMPASSIBILITY_OF_TERRAIN_TO] - $range[self::IMPASSIBILITY_OF_TERRAIN_FROM];
        $addition = $difference * $difficultyPercents->getRate();

        return SumAndRound::round($range[self::IMPASSIBILITY_OF_TERRAIN_FROM] + $addition);
    }

    /**
     * @param TerrainCode $terrainCode
     * @return array|\int[]
     * @throws \DrdPlus\Tables\Environments\Exceptions\UnknownTerrainCode
     * @throws \DrdPlus\Tables\Environments\Exceptions\InvalidTerrainCodeFormat
     */
    public function getSpeedMalusValuesRangeForTerrain(TerrainCode $terrainCode)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getRow([$terrainCode]);
        } catch (RequiredRowNotFound $requiredRowDataNotFound) {
            throw new Exceptions\UnknownTerrainCode('Unknown terrain code ' . ValueDescriber::describe($terrainCode));
        } catch (WrongParameterType $wrongParameterType) {
            throw new Exceptions\InvalidTerrainCodeFormat(
                'Unexpected format of a terrain code: ' . ValueDescriber::describe($terrainCode)
            );
        }
    }

}