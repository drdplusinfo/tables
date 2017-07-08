<?php
namespace DrdPlus\Tables\Activities;

use Drd\DiceRolls\Templates\Rolls\Roll1d6;
use DrdPlus\Calculations\SumAndRound;
use DrdPlus\Codes\Environment\LandingSurfaceCode;
use DrdPlus\Codes\JumpMovementCode;
use DrdPlus\Codes\JumpTypeCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Body\Weight;
use DrdPlus\Properties\Derived\Athletics;
use DrdPlus\Properties\Derived\Speed;
use DrdPlus\Tables\Environments\LandingSurfacesTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\PositiveInteger;

/**
 * See PPH page 119 right column, @link https://pph.drdplus.info/#tabulka_skoku
 */
class JumpsAndFallsTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/jumps_and_falls.csv';
    }

    /**
     * @return array
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            JumpMovementCode::STANDING_JUMP => self::INTEGER,
            JumpMovementCode::FLYING_JUMP => self::INTEGER,
        ];
    }

    const JUMP_TYPE = 'jump_type';

    /**
     * @return array
     */
    protected function getRowsHeader(): array
    {
        return [
            self::JUMP_TYPE,
        ];
    }

    /**
     * @param JumpTypeCode $jumpTypeCode
     * @param Distance $ranDistance
     * @return int
     */
    public function getModifierToJump(JumpTypeCode $jumpTypeCode, Distance $ranDistance): int
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($jumpTypeCode, $this->getJumpMovementCodeByRanDistance($ranDistance));
    }

    /**
     * @param Distance $ranDistance
     * @return string
     */
    private function getJumpMovementCodeByRanDistance(Distance $ranDistance): string
    {
        if ($ranDistance->getMeters() >= 5) {
            return JumpMovementCode::FLYING_JUMP;
        }

        return JumpMovementCode::STANDING_JUMP;
    }

    /**
     * @param Speed $speed
     * @param Athletics $athletics
     * @param JumpTypeCode $jumpTypeCode
     * @param Distance $ranDistance
     * @param Roll1d6 $roll1D6
     * @return int
     */
    public function getJumpLength(
        Speed $speed,
        Athletics $athletics,
        JumpTypeCode $jumpTypeCode,
        Distance $ranDistance,
        Roll1d6 $roll1D6
    ): int
    {
        return $this->getModifierToJump($jumpTypeCode, $ranDistance)
            + SumAndRound::half($speed->getValue())
            + $athletics->getAthleticsBonus()->getValue()
            + $roll1D6->getValue();
    }

    /**
     * @param Distance $fallHeight
     * @param Weight $bodyWeight
     * @param Roll1d6 $roll1D6
     * @param bool $itIsControlledJump
     * @param Agility $agility
     * @param Athletics $athletics
     * @param WoundsTable $woundsTable
     * @param LandingSurfaceCode $landingSurfaceCode
     * @param PositiveInteger $armorProtection
     * @param LandingSurfacesTable $landingSurfacesTable
     * @return Wounds
     */
    public function getWoundsFromJumpOrFall(
        Distance $fallHeight,
        Weight $bodyWeight,
        Roll1d6 $roll1D6,
        bool $itIsControlledJump,
        Agility $agility,
        Athletics $athletics,
        LandingSurfaceCode $landingSurfaceCode,
        PositiveInteger $armorProtection,
        WoundsTable $woundsTable,
        LandingSurfacesTable $landingSurfacesTable
    ): Wounds
    {
        $meters = $fallHeight->getMeters();
        if ($itIsControlledJump) {
            $meters -= 2;
        }
        $powerOfWound = $meters + SumAndRound::half($bodyWeight->getValue()) - 5 + $roll1D6->getValue();
        $powerOfWound += $landingSurfacesTable->getWoundsModifier($landingSurfaceCode, $agility, $armorProtection);
        if ($powerOfWound < 0) {
            $powerOfWound = 0;
        }
        $convertedPowerOfWounds = (new WoundsBonus($powerOfWound, $woundsTable))->getWounds()->getValue();
        $convertedAgilityAndAthletics = (new WoundsBonus(
            $agility->getValue() + $athletics->getAthleticsBonus()->getValue(),
            $woundsTable)
        )->getWounds()->getValue();
        $woundsValue = $convertedPowerOfWounds - $convertedAgilityAndAthletics;
        if ($woundsValue < 0) {
            $woundsValue = 0;
        }

        return new Wounds($woundsValue, $woundsTable);
    }
}