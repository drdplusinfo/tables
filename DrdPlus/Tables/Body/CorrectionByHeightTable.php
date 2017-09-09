<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Body;

use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Body\Height;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;

/**
 * See PPH page 40 right column bottom, @link https://pph.drdplus.info/#tabulka_oprav_za_vysku
 * for speed @link https://pph.drdplus.info/#oprava_rychlosti_za_vysku
 * and for fight @link https://pph.drdplus.info/#oprava_boje_za_vysku
 */
class CorrectionByHeightTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/correction_by_height.csv';
    }

    const CORRECTION = 'correction';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [self::CORRECTION => self::INTEGER];
    }

    /**
     * @return array
     */
    protected function getRowsHeader(): array
    {
        return [PropertyCode::HEIGHT];
    }

    /**
     * @param Height $height
     * @return int
     * @throws \DrdPlus\Tables\Body\Exceptions\UnexpectedHeightToGetCorrectionFor
     */
    public function getCorrectionByHeight(Height $height)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue($height, self::CORRECTION);
        } catch (RequiredRowNotFound $requiredRowNotFound) {
            throw new Exceptions\UnexpectedHeightToGetCorrectionFor(
                "Given height {$height} is out of range to get a correction"
            );
        }
    }
}