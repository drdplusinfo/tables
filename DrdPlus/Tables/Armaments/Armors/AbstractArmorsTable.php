<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Exceptions\UnknownArmor;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\UnwieldyTable;
use Granam\String\StringInterface;
use Granam\Tools\ValueDescriber;

abstract class AbstractArmorsTable extends AbstractArmamentsTable implements UnwieldyTable
{

    const PROTECTION = 'protection';

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
        ];
    }

    /**
     * @param string|StringInterface $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getRequiredStrengthOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string|StringInterface $armorCode
     * @param $valueName
     * @return bool|float|int|string
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    protected function getValueFor($armorCode, string $valueName)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue([$armorCode], $valueName);
        } catch (\DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound $exception) {
            throw new UnknownArmor(
                'Unknown armor code ' . ValueDescriber::describe($armorCode)
            );
        }
    }

    /**
     * @param string|StringInterface $armorCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getRestrictionOf($armorCode): int
    {
        return $this->getValueFor($armorCode, self::RESTRICTION);
    }

    /**
     * @param string|StringInterface $armorCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getProtectionOf($armorCode): int
    {
        return $this->getValueFor($armorCode, self::PROTECTION);
    }

    /**
     * @param string|StringInterface $armorCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function getWeightOf($armorCode): float
    {
        return $this->getValueFor($armorCode, self::WEIGHT);
    }
}