<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\UnwieldyParametersInterface;
use Granam\Tools\ValueDescriber;

abstract class AbstractArmorsTable extends AbstractArmamentsTable implements UnwieldyParametersInterface
{

    const PROTECTION = 'protection';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::RESTRICTION => self::INTEGER,
            self::PROTECTION => self::INTEGER,
            self::WEIGHT => self::FLOAT,
        ];
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function getRequiredStrengthOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string $armorCode
     * @param $valueName
     * @return bool|float|int|string
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    private function getValueFor($armorCode, $valueName)
    {
        try {
            return $this->getValue([$armorCode], $valueName);
        } catch (\DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound $exception) {
            throw new Exceptions\UnknownArmorCode(
                'Unknown armor code ' . ValueDescriber::describe($armorCode)
            );
        }
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function getRestrictionOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::RESTRICTION);
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function getProtectionOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::PROTECTION);
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function getWeightOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::WEIGHT);
    }
}