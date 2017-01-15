<?php
namespace DrdPlus\Tables\Armaments\Armors;

/**
 * See PPH page 90 left column, https://pph.drdplus.jaroslavtyc.com/#tabulka_zbroji_a_prileb
 */
class BodyArmorsTable extends AbstractArmorsTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/body_armors.csv';
    }

    const ROUNDS_TO_PUT_ON = 'rounds_to_put_on';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
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
    protected function getRowsHeader()
    {
        return [self::BODY_ARMOR];
    }

    /**
     * @param string $armorCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getRoundsToPutOnOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::ROUNDS_TO_PUT_ON);
    }
}