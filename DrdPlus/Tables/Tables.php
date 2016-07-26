<?php
namespace DrdPlus\Tables;

use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Sanctions\ArmorSanctionsTable;
use DrdPlus\Tables\Armaments\Sanctions\MeleeWeaponSanctionsTable;
use DrdPlus\Tables\Armaments\Sanctions\RangeWeaponSanctionsTable;
use DrdPlus\Tables\Armaments\Shields\ShieldsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\AxesTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\KnifesAndDaggersTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\MacesAndClubsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\MorningstarsAndMorgensternsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\SabersAndBowieKnifesTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\StaffsAndSpearsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\SwordsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\UnarmedTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\VoulgesAndTridentsTable;
use DrdPlus\Tables\Armaments\Weapons\MissingWeaponSkillsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\ArrowsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\BowsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\CrossbowsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\DartsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\SlingStonesTable;
use DrdPlus\Tables\Armaments\Weapons\Range\ThrowingWeaponsTable;
use DrdPlus\Tables\Body\FatigueByLoad\FatigueByLoadTable;
use DrdPlus\Tables\Body\Healing\HealingByActivityTable;
use DrdPlus\Tables\Body\Healing\HealingByConditionsTable;
use DrdPlus\Tables\Body\MovementTypes\MovementTypesTable;
use DrdPlus\Tables\Body\Resting\RestingBySituationTable;
use DrdPlus\Tables\Environments\ImpassibilityOfTerrainTable;
use DrdPlus\Tables\Equipment\Riding\RidesTable;
use DrdPlus\Tables\Equipment\Riding\RidingAnimalMovementTypesTable;
use DrdPlus\Tables\Equipment\Riding\RidingAnimalsTable;
use DrdPlus\Tables\Equipment\Riding\WoundsOnFallFromHorseTable;
use DrdPlus\Tables\Measurements\Amount\AmountTable;
use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Measurements\Experiences\ExperiencesTable;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\BonusAdjustmentByTimeTable;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tables\Professions\BackgroundSkillsTable;
use DrdPlus\Tables\Races\FemaleModifiersTable;
use DrdPlus\Tables\Races\RacesTable;
use Granam\Strict\Object\StrictObject;

class Tables extends StrictObject implements \IteratorAggregate
{
    /**
     * @var array|Table[]
     */
    private $tables = [];
    /**
     * @var Armourer
     */
    private $armourer;

    /**
     * @return AmountTable
     */
    public function getAmountTable()
    {
        if (!array_key_exists(AmountTable::class, $this->tables)) {
            $this->tables[AmountTable::class] = new AmountTable();
        }

        return $this->tables[AmountTable::class];
    }

    /**
     * @return BaseOfWoundsTable
     */
    public function getBaseOfWoundsTable()
    {
        if (!array_key_exists(BaseOfWoundsTable::class, $this->tables)) {
            $this->tables[BaseOfWoundsTable::class] = new BaseOfWoundsTable();
        }

        return $this->tables[BaseOfWoundsTable::class];
    }

    /**
     * @return DistanceTable
     */
    public function getDistanceTable()
    {
        if (!array_key_exists(DistanceTable::class, $this->tables)) {
            $this->tables[DistanceTable::class] = new DistanceTable();
        }

        return $this->tables[DistanceTable::class];
    }

    /**
     * @return ExperiencesTable
     */
    public function getExperiencesTable()
    {
        if (!array_key_exists(ExperiencesTable::class, $this->tables)) {
            $this->tables[ExperiencesTable::class] = new ExperiencesTable($this->getWoundsTable());
        }

        return $this->tables[ExperiencesTable::class];
    }

    /**
     * @return FatigueTable
     */
    public function getFatigueTable()
    {
        if (!array_key_exists(FatigueTable::class, $this->tables)) {
            $this->tables[FatigueTable::class] = new FatigueTable($this->getWoundsTable());
        }

        return $this->tables[FatigueTable::class];
    }

    /**
     * @return SpeedTable
     */
    public function getSpeedTable()
    {
        if (!array_key_exists(SpeedTable::class, $this->tables)) {
            $this->tables[SpeedTable::class] = new SpeedTable();
        }

        return $this->tables[SpeedTable::class];
    }

    /**
     * @return TimeTable
     */
    public function getTimeTable()
    {
        if (!array_key_exists(TimeTable::class, $this->tables)) {
            $this->tables[TimeTable::class] = new TimeTable();
        }

        return $this->tables[TimeTable::class];
    }

    /**
     * @return BonusAdjustmentByTimeTable
     */
    public function getBonusAdjustmentByTimeTable()
    {
        if (!array_key_exists(BonusAdjustmentByTimeTable::class, $this->tables)) {
            $this->tables[BonusAdjustmentByTimeTable::class] = new BonusAdjustmentByTimeTable($this->getTimeTable());
        }

        return $this->tables[BonusAdjustmentByTimeTable::class];
    }

    /**
     * @return WeightTable
     */
    public function getWeightTable()
    {
        if (!array_key_exists(WeightTable::class, $this->tables)) {
            $this->tables[WeightTable::class] = new WeightTable();
        }

        return $this->tables[WeightTable::class];
    }

    /**
     * @return WoundsTable
     */
    public function getWoundsTable()
    {
        if (!array_key_exists(WoundsTable::class, $this->tables)) {
            $this->tables[WoundsTable::class] = new WoundsTable();
        }

        return $this->tables[WoundsTable::class];
    }

    /**
     * @return FemaleModifiersTable
     */
    public function getFemaleModifiersTable()
    {
        if (!array_key_exists(FemaleModifiersTable::class, $this->tables)) {
            $this->tables[FemaleModifiersTable::class] = new FemaleModifiersTable();
        }

        return $this->tables[FemaleModifiersTable::class];
    }

    /**
     * @return RacesTable
     */
    public function getRacesTable()
    {
        if (!array_key_exists(RacesTable::class, $this->tables)) {
            $this->tables[RacesTable::class] = new RacesTable();
        }

        return $this->tables[RacesTable::class];
    }

    /**
     * @return BackgroundSkillsTable
     */
    public function getBackgroundSkillsTable()
    {
        if (!array_key_exists(BackgroundSkillsTable::class, $this->tables)) {
            $this->tables[BackgroundSkillsTable::class] = new BackgroundSkillsTable();
        }

        return $this->tables[BackgroundSkillsTable::class];
    }

    /**
     * @return BodyArmorsTable
     */
    public function getBodyArmorsTable()
    {
        if (!array_key_exists(BodyArmorsTable::class, $this->tables)) {
            $this->tables[BodyArmorsTable::class] = new BodyArmorsTable();
        }

        return $this->tables[BodyArmorsTable::class];
    }

    /**
     * @return HelmsTable
     */
    public function getHelmsTable()
    {
        if (!array_key_exists(HelmsTable::class, $this->tables)) {
            $this->tables[HelmsTable::class] = new HelmsTable();
        }

        return $this->tables[HelmsTable::class];
    }

    /**
     * @return ArmorSanctionsTable
     */
    public function getArmorSanctionsTable()
    {
        if (!array_key_exists(ArmorSanctionsTable::class, $this->tables)) {
            $this->tables[ArmorSanctionsTable::class] = new ArmorSanctionsTable();
        }

        return $this->tables[ArmorSanctionsTable::class];
    }

    /**
     * @return MeleeWeaponSanctionsTable
     */
    public function getMeleeWeaponSanctionsTable()
    {
        if (!array_key_exists(MeleeWeaponSanctionsTable::class, $this->tables)) {
            $this->tables[MeleeWeaponSanctionsTable::class] = new MeleeWeaponSanctionsTable();
        }

        return $this->tables[MeleeWeaponSanctionsTable::class];
    }

    /**
     * @return RangeWeaponSanctionsTable
     */
    public function getRangeWeaponSanctionsTable()
    {
        if (!array_key_exists(RangeWeaponSanctionsTable::class, $this->tables)) {
            $this->tables[RangeWeaponSanctionsTable::class] = new RangeWeaponSanctionsTable();
        }

        return $this->tables[RangeWeaponSanctionsTable::class];
    }

    /**
     * @return MissingWeaponSkillsTable
     */
    public function getMissingWeaponSkillsTable()
    {
        if (!array_key_exists(MissingWeaponSkillsTable::class, $this->tables)) {
            $this->tables[MissingWeaponSkillsTable::class] = new MissingWeaponSkillsTable();
        }

        return $this->tables[MissingWeaponSkillsTable::class];
    }

    /**
     * @return ShieldsTable
     */
    public function getShieldsTable()
    {
        if (!array_key_exists(ShieldsTable::class, $this->tables)) {
            $this->tables[ShieldsTable::class] = new ShieldsTable();
        }

        return $this->tables[ShieldsTable::class];
    }

    /**
     * @return AxesTable
     */
    public function getAxesTable()
    {
        if (!array_key_exists(AxesTable::class, $this->tables)) {
            $this->tables[AxesTable::class] = new AxesTable();
        }

        return $this->tables[AxesTable::class];
    }

    /**
     * @return KnifesAndDaggersTable
     */
    public function getKnifesAndDaggersTable()
    {
        if (!array_key_exists(KnifesAndDaggersTable::class, $this->tables)) {
            $this->tables[KnifesAndDaggersTable::class] = new KnifesAndDaggersTable();
        }

        return $this->tables[KnifesAndDaggersTable::class];
    }

    /**
     * @return MacesAndClubsTable
     */
    public function getMacesAndClubsTable()
    {
        if (!array_key_exists(MacesAndClubsTable::class, $this->tables)) {
            $this->tables[MacesAndClubsTable::class] = new MacesAndClubsTable();
        }

        return $this->tables[MacesAndClubsTable::class];
    }

    /**
     * @return MorningstarsAndMorgensternsTable
     */
    public function getMorningStarsAndMorgensternsTable()
    {
        if (!array_key_exists(MorningstarsAndMorgensternsTable::class, $this->tables)) {
            $this->tables[MorningstarsAndMorgensternsTable::class] = new MorningstarsAndMorgensternsTable();
        }

        return $this->tables[MorningstarsAndMorgensternsTable::class];
    }

    /**
     * @return SabersAndBowieKnifesTable
     */
    public function getSabersAndBowieKnifesTable()
    {
        if (!array_key_exists(SabersAndBowieKnifesTable::class, $this->tables)) {
            $this->tables[SabersAndBowieKnifesTable::class] = new SabersAndBowieKnifesTable();
        }

        return $this->tables[SabersAndBowieKnifesTable::class];
    }

    /**
     * @return StaffsAndSpearsTable
     */
    public function getStaffsAndSpearsTable()
    {
        if (!array_key_exists(StaffsAndSpearsTable::class, $this->tables)) {
            $this->tables[StaffsAndSpearsTable::class] = new StaffsAndSpearsTable();
        }

        return $this->tables[StaffsAndSpearsTable::class];
    }

    /**
     * @return SwordsTable
     */
    public function getSwordsTable()
    {
        if (!array_key_exists(SwordsTable::class, $this->tables)) {
            $this->tables[SwordsTable::class] = new SwordsTable();
        }

        return $this->tables[SwordsTable::class];
    }

    /**
     * @return VoulgesAndTridentsTable
     */
    public function getVoulgesAndTridentsTable()
    {
        if (!array_key_exists(VoulgesAndTridentsTable::class, $this->tables)) {
            $this->tables[VoulgesAndTridentsTable::class] = new VoulgesAndTridentsTable();
        }

        return $this->tables[VoulgesAndTridentsTable::class];
    }

    /**
     * @return UnarmedTable
     */
    public function getUnarmedTable()
    {
        if (!array_key_exists(UnarmedTable::class, $this->tables)) {
            $this->tables[UnarmedTable::class] = new UnarmedTable();
        }

        return $this->tables[UnarmedTable::class];
    }

    /**
     * @return ArrowsTable
     */
    public function getArrowsTable()
    {
        if (!array_key_exists(ArrowsTable::class, $this->tables)) {
            $this->tables[ArrowsTable::class] = new ArrowsTable();
        }

        return $this->tables[ArrowsTable::class];
    }

    /**
     * @return BowsTable
     */
    public function getBowsTable()
    {
        if (!array_key_exists(BowsTable::class, $this->tables)) {
            $this->tables[BowsTable::class] = new BowsTable();
        }

        return $this->tables[BowsTable::class];
    }

    /**
     * @return DartsTable
     */
    public function getDartsTable()
    {
        if (!array_key_exists(DartsTable::class, $this->tables)) {
            $this->tables[DartsTable::class] = new DartsTable();
        }

        return $this->tables[DartsTable::class];
    }

    /**
     * @return CrossbowsTable
     */
    public function getCrossbowsTable()
    {
        if (!array_key_exists(CrossbowsTable::class, $this->tables)) {
            $this->tables[CrossbowsTable::class] = new CrossbowsTable();
        }

        return $this->tables[CrossbowsTable::class];
    }

    /**
     * @return SlingStonesTable
     */
    public function getSlingStonesTable()
    {
        if (!array_key_exists(SlingStonesTable::class, $this->tables)) {
            $this->tables[SlingStonesTable::class] = new SlingStonesTable();
        }

        return $this->tables[SlingStonesTable::class];
    }

    /**
     * @return ThrowingWeaponsTable
     */
    public function getThrowingWeaponsTable()
    {
        if (!array_key_exists(ThrowingWeaponsTable::class, $this->tables)) {
            $this->tables[ThrowingWeaponsTable::class] = new ThrowingWeaponsTable();
        }

        return $this->tables[ThrowingWeaponsTable::class];
    }

    /**
     * @return HealingByActivityTable
     */
    public function getHealingByActivityTable()
    {
        if (!array_key_exists(HealingByActivityTable::class, $this->tables)) {
            $this->tables[HealingByActivityTable::class] = new HealingByActivityTable();
        }

        return $this->tables[HealingByActivityTable::class];
    }

    /**
     * @return HealingByConditionsTable
     */
    public function getHealingByConditionsTable()
    {
        if (!array_key_exists(HealingByConditionsTable::class, $this->tables)) {
            $this->tables[HealingByConditionsTable::class] = new HealingByConditionsTable();
        }

        return $this->tables[HealingByConditionsTable::class];
    }

    /**
     * @return MovementTypesTable
     */
    public function getMovementTypesTable()
    {
        if (!array_key_exists(MovementTypesTable::class, $this->tables)) {
            $this->tables[MovementTypesTable::class] = new MovementTypesTable($this->getSpeedTable(), $this->getTimeTable());
        }

        return $this->tables[MovementTypesTable::class];
    }

    /**
     * @return ImpassibilityOfTerrainTable
     */
    public function getImpassibilityOfTerrainTable()
    {
        if (!array_key_exists(ImpassibilityOfTerrainTable::class, $this->tables)) {
            $this->tables[ImpassibilityOfTerrainTable::class] = new ImpassibilityOfTerrainTable();
        }

        return $this->tables[ImpassibilityOfTerrainTable::class];
    }

    /**
     * @return FatigueByLoadTable
     */
    public function getFatigueByLoadTable()
    {
        if (!array_key_exists(FatigueByLoadTable::class, $this->tables)) {
            $this->tables[FatigueByLoadTable::class] = new FatigueByLoadTable();
        }

        return $this->tables[FatigueByLoadTable::class];
    }

    /**
     * @return RestingBySituationTable
     */
    public function getRestingBySituationTable()
    {
        if (!array_key_exists(RestingBySituationTable::class, $this->tables)) {
            $this->tables[RestingBySituationTable::class] = new RestingBySituationTable();
        }

        return $this->tables[RestingBySituationTable::class];
    }

    /**
     * @return RidesTable
     */
    public function getRidesTable()
    {
        if (!array_key_exists(RidesTable::class, $this->tables)) {
            $this->tables[RidesTable::class] = new RidesTable();
        }

        return $this->tables[RidesTable::class];
    }

    /**
     * @return RidingAnimalMovementTypesTable
     */
    public function getRidingAnimalMovementTypesTable()
    {
        if (!array_key_exists(RidingAnimalMovementTypesTable::class, $this->tables)) {
            $this->tables[RidingAnimalMovementTypesTable::class] = new RidingAnimalMovementTypesTable(
                $this->getSpeedTable(),
                $this->getTimeTable(),
                $this->getMovementTypesTable()
            );
        }

        return $this->tables[RidingAnimalMovementTypesTable::class];
    }

    /**
     * @return RidingAnimalsTable
     */
    public function getRidingAnimalsTable()
    {
        if (!array_key_exists(RidingAnimalsTable::class, $this->tables)) {
            $this->tables[RidingAnimalsTable::class] = new RidingAnimalsTable();
        }

        return $this->tables[RidingAnimalsTable::class];
    }

    /**
     * @return WoundsOnFallFromHorseTable
     */
    public function getWoundsOnFallFromHorseTable()
    {
        if (!array_key_exists(WoundsOnFallFromHorseTable::class, $this->tables)) {
            $this->tables[WoundsOnFallFromHorseTable::class] = new WoundsOnFallFromHorseTable();
        }

        return $this->tables[WoundsOnFallFromHorseTable::class];
    }

    public function getIterator()
    {
        return new \ArrayObject([
            $this->getAmountTable(),
            $this->getBackgroundSkillsTable(),
            $this->getBaseOfWoundsTable(),
            $this->getDistanceTable(),
            $this->getExperiencesTable(),
            $this->getFatigueTable(),
            $this->getFemaleModifiersTable(),
            $this->getRacesTable(),
            $this->getSpeedTable(),
            $this->getTimeTable(),
            $this->getBonusAdjustmentByTimeTable(),
            $this->getWeightTable(),
            $this->getWoundsTable(),
            $this->getBodyArmorsTable(),
            $this->getHelmsTable(),
            $this->getArmorSanctionsTable(),
            $this->getShieldsTable(),
            $this->getAxesTable(),
            $this->getKnifesAndDaggersTable(),
            $this->getMacesAndClubsTable(),
            $this->getMorningStarsAndMorgensternsTable(),
            $this->getSabersAndBowieKnifesTable(),
            $this->getStaffsAndSpearsTable(),
            $this->getSwordsTable(),
            $this->getVoulgesAndTridentsTable(),
            $this->getUnarmedTable(),
            $this->getArrowsTable(),
            $this->getBowsTable(),
            $this->getDartsTable(),
            $this->getCrossbowsTable(),
            $this->getSlingStonesTable(),
            $this->getThrowingWeaponsTable(),
            $this->getMeleeWeaponSanctionsTable(),
            $this->getRangeWeaponSanctionsTable(),
            $this->getMissingWeaponSkillsTable(),
            $this->getHealingByActivityTable(),
            $this->getHealingByConditionsTable(),
            $this->getMovementTypesTable(),
            $this->getImpassibilityOfTerrainTable(),
            $this->getFatigueByLoadTable(),
            $this->getRestingBySituationTable(),
            $this->getRidesTable(),
            $this->getRidingAnimalMovementTypesTable(),
            $this->getRidingAnimalsTable(),
            $this->getWoundsOnFallFromHorseTable()
        ]);
    }

    /**
     * @return Armourer
     */
    public function getArmourer()
    {
        if ($this->armourer === null) {
            $this->armourer = new Armourer($this);
        }

        return $this->armourer;
    }

}