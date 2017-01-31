<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Codes\Environment\LandingSurfaceCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\PositiveInteger;

/**
 * See PPH page 119 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_povrchu
 */
class LandingSurfacesTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/landing_surfaces.csv';
    }

    const POWER_OF_WOUND_MODIFIER = 'power_of_wound_modifier';
    const AGILITY_MULTIPLIER_PROTECTION = 'agility_multiplier_protection';
    const ARMOR_MAX_PROTECTION = 'armor_max_protection';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::POWER_OF_WOUND_MODIFIER => self::INTEGER,
            self::AGILITY_MULTIPLIER_PROTECTION => self::POSITIVE_INTEGER,
            self::ARMOR_MAX_PROTECTION => self::POSITIVE_INTEGER,
        ];
    }

    const SURFACE = 'surface';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::SURFACE];
    }

    /**
     * @param LandingSurfaceCode $landingSurfaceCode
     * @param Agility $agility
     * @param PositiveInteger $armorProtection
     * @return int
     */
    public function getPowerOfWoundModifier(
        LandingSurfaceCode $landingSurfaceCode,
        Agility $agility,
        PositiveInteger $armorProtection
    )
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $row = $this->getRow($landingSurfaceCode);
        $powerOfWoundModifier = $row[self::POWER_OF_WOUND_MODIFIER];
        $agilityMultiplierBonus = $row[self::AGILITY_MULTIPLIER_PROTECTION];
        if ($agilityMultiplierBonus) {
            $powerOfWoundModifier -= $agilityMultiplierBonus * $agility->getValue();
        }
        $armorMaxProtection = $row[self::ARMOR_MAX_PROTECTION];
        if ($armorMaxProtection) {
            if ($armorProtection->getValue() > $armorMaxProtection) {
                $powerOfWoundModifier -= $armorMaxProtection;
            } else {
                $powerOfWoundModifier -= $armorProtection->getValue();
            }
        }

        return $powerOfWoundModifier;
    }

}