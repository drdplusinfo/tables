<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Exceptions\UnknownArmor;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\UnwieldyTable;
use Granam\Tools\ValueDescriber;

abstract class AbstractArmorsTable extends AbstractArmamentsTable implements UnwieldyTable
{

    const PROTECTION = 'protection';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::RESTRICTION => self::INTEGER,
            self::PROTECTION => self::POSITIVE_INTEGER,
            self::WEIGHT => self::FLOAT,
        ];
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getRequiredStrengthOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string $armorCode
     * @param $valueName
     * @return bool|float|int|string
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    protected function getValueFor($armorCode, $valueName)
    {
        try {
            return $this->getValue([$armorCode], $valueName);
        } catch (\DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound $exception) {
            throw new UnknownArmor(
                'Unknown armor code ' . ValueDescriber::describe($armorCode)
            );
        }
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getRestrictionOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::RESTRICTION);
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getProtectionOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::PROTECTION);
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getWeightOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::WEIGHT);
    }
}