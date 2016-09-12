<?php
namespace DrdPlus\Tables\Armaments\Armors;

class BodyArmorsTable extends AbstractArmorsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/body_armors.csv';
    }

    const ROUNDS_TO_PUT_ON = 'rounds_to_put_on';

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

    protected function getRowsHeader()
    {
        return ['body_armor'];
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