<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Armors;

use Granam\String\StringInterface;

/**
 * See PPH page 90 left column, @link https://pph.drdplus.info/#tabulka_zbroji_a_prileb
 */
class BodyArmorsTable extends AbstractArmorsTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/body_armors.csv';
    }

    const ROUNDS_TO_PUT_ON = 'rounds_to_put_on';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::RESTRICTION => self::INTEGER,
            self::PROTECTION => self::POSITIVE_INTEGER,
            self::WEIGHT => self::FLOAT,
            self::ROUNDS_TO_PUT_ON => self::POSITIVE_INTEGER,
        ];
    }

    const BODY_ARMOR = 'body_armor';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::BODY_ARMOR];
    }

    /**
     * @param string|StringInterface $armorCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getRoundsToPutOnOf($armorCode): int
    {
        return $this->getValueFor($armorCode, self::ROUNDS_TO_PUT_ON);
    }
}