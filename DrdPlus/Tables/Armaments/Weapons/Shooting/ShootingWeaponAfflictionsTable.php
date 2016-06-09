<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\Tools\ToInteger;

class ShootingWeaponAfflictionsTable extends AbstractFileTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/shooting_weapon_afflictions.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['missing_strength'];
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            'fight_number/loading' => self::SLASH_ARRAY_OF_INTEGERS,
            'attack_number' => self::INTEGER,
            'encounter_range' => self::INTEGER,
            'base_of_wounds' => self::INTEGER
        ];
    }

    const MAX_MISSING_STRENGTH = 10;

    /**
     * @param int $missingStrength
     * @return bool
     */
    public function canUseWeapon($missingStrength)
    {
        return ToInteger::toInteger($missingStrength) <= self::MAX_MISSING_STRENGTH;
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getFightNumberAffliction($missingStrength)
    {
        return $this->getAfflictionOf($missingStrength, 'fight_number/loading', 0 /* index of array */);
    }

    /**
     * @param int $missingStrength
     * @param string $columnName
     * @param bool|int $indexOfArrayValue
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    private function getAfflictionOf($missingStrength, $columnName, $indexOfArrayValue = false)
    {
        if ($missingStrength < 1) {
            return 0; // no missing strength, no affliction at all
        }
        $this->guardMissingStrengthMaximum($missingStrength);
        $value = $this->getValue([$missingStrength], $columnName);
        if (!is_array($value)) {
            return $value;
        }

        /**
         * @var array $value
         * @var int $indexOfArrayValue
         */
        return $value[$indexOfArrayValue];
    }

    /**
     * @param int $missingStrength
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    private function guardMissingStrengthMaximum($missingStrength)
    {
        if (!$this->canUseWeapon($missingStrength)) {
            throw new Exceptions\CanNotUseWeaponBecauseOfMissingStrength(
                "Too much missing strength {$missingStrength} to bear a shooting weapon"
            );
        }
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getLoadingAffliction($missingStrength)
    {
        return $this->getAfflictionOf($missingStrength, 'fight_number/loading', 1 /* array index */);
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getAttackNumberAffliction($missingStrength)
    {
        return $this->getAfflictionOf($missingStrength, 'attack_number');
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getEncounterRangeAffliction($missingStrength)
    {
        return $this->getAfflictionOf($missingStrength, 'encounter_range');
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    public function getBaseOfWoundsAffliction($missingStrength)
    {
        return $this->getAfflictionOf($missingStrength, 'base_of_wounds');
    }

}