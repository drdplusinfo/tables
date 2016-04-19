<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;
use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Sanctions\ArmorSanctionsTable;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;

class Armourer extends StrictObject
{
    /**
     * @var ArmorSanctionsTable
     */
    private $armorSanctionsTable;
    /**
     * @var BodyArmorsTable
     */
    private $bodyArmorsTable;
    /**
     * @var HelmsTable
     */
    private $helmsTable;

    public function __construct(
        ArmorSanctionsTable $armorSanctionsTable,
        BodyArmorsTable $bodyArmorsTable,
        HelmsTable $helmsTable
    )
    {
        $this->armorSanctionsTable = $armorSanctionsTable;
        $this->bodyArmorsTable = $bodyArmorsTable;
        $this->helmsTable = $helmsTable;
    }

    /**
     * @param string $armorCode
     * @param int $bodySize
     * @param int $strength
     * @return array|\mixed[]
     */
    public function getSanctionValuesForBodyArmor($armorCode, $bodySize, $strength)
    {
        return $this->armorSanctionsTable->getSanctionValuesForMissingStrength(
            $this->getMissingStrengthForBodyArmor($armorCode, $bodySize, $strength)
        );
    }

    /**
     * @param string $armorCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     */
    public function getMissingStrengthForBodyArmor($armorCode, $bodySize, $strength)
    {
        return $this->getMissingStrengthForArmor($this->bodyArmorsTable, $armorCode, $bodySize, $strength);
    }

    /**
     * See PPH page 91, right column
     * @param string $armorCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     */
    private function getMissingStrengthForArmor(
        AbstractArmorsTable $abstractArmorsTable,
        $armorCode,
        $bodySize,
        $strength
    )
    {
        $requiredStrength = $abstractArmorsTable->getRequiredStrengthOf($armorCode);
        if ($requiredStrength === false) {
            return 0;
        }

        return $requiredStrength + $bodySize - ToInteger::toInteger($strength);
    }

    /**
     * @param string $helmCode
     * @param int $bodySize
     * @param int $strength
     * @return array|\mixed[]
     */
    public function getSanctionValuesForHelm($helmCode, $bodySize, $strength)
    {
        return $this->armorSanctionsTable->getSanctionValuesForMissingStrength(
            $this->getMissingStrengthForHelm($helmCode, $bodySize, $strength)
        );
    }

    /**
     * @param string $helmCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     */
    public function getMissingStrengthForHelm($helmCode, $bodySize, $strength)
    {
        return $this->getMissingStrengthForArmor($this->helmsTable, $helmCode, $bodySize, $strength);
    }

}