<?php
namespace DrdPlus\Tables\Body\MovementTypes;

use DrdPlus\Codes\TimeUnitCode;
use DrdPlus\Codes\Transport\MovementTypeCode;
use DrdPlus\Properties\Derived\Endurance;
use DrdPlus\Tables\Measurements\Speed\SpeedBonus;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeBonus;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Tools\ValueDescriber;

/**
 * See PPH page 112 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_druhu_pohybu
 */
class MovementTypesTable extends AbstractFileTable
{
    /**
     * @var SpeedTable
     */
    private $speedTable;
    /**
     * @var TimeTable
     */
    private $timeTable;

    /**
     * @param SpeedTable $speedTable
     * @param TimeTable $timeTable
     */
    public function __construct(SpeedTable $speedTable, TimeTable $timeTable)
    {
        $this->speedTable = $speedTable;
        $this->timeTable = $timeTable;
    }

    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/movement_types.csv';
    }

    const MOVEMENT_TYPE = 'movement_type';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::MOVEMENT_TYPE,];
    }

    const BONUS_TO_MOVEMENT_SPEED = 'bonus_to_movement_speed';
    const HOURS_PER_POINT_OF_FATIGUE = 'hours_per_point_of_fatigue';
    const MINUTES_PER_POINT_OF_FATIGUE = 'minutes_per_point_of_fatigue';
    const ROUNDS_PER_POINT_OF_FATIGUE = 'rounds_per_point_of_fatigue';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            self::BONUS_TO_MOVEMENT_SPEED => self::INTEGER,
            self::HOURS_PER_POINT_OF_FATIGUE => self::FLOAT,
            self::MINUTES_PER_POINT_OF_FATIGUE => self::FLOAT,
            self::ROUNDS_PER_POINT_OF_FATIGUE => self::FLOAT,
        ];
    }

    const WAITING = MovementTypeCode::WAITING;
    const WALK = MovementTypeCode::WALK;
    const RUSH = MovementTypeCode::RUSH;
    const RUN = MovementTypeCode::RUN;
    const SPRINT = MovementTypeCode::SPRINT;

    /**
     * @param string $movementType
     * @return SpeedBonus
     * @throws \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     */
    public function getSpeedBonus($movementType)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return new SpeedBonus(
                $this->getValue([$movementType], self::BONUS_TO_MOVEMENT_SPEED),
                $this->speedTable
            );
        } catch (RequiredRowNotFound $requiredRowDataNotFound) {
            throw new Exceptions\UnknownMovementType(
                'Given movement type is not known ' . ValueDescriber::describe($movementType)
            );
        }
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnWaiting(): SpeedBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::WAITING);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnWalk(): SpeedBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::WALK);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnRush(): SpeedBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::RUSH);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnRun(): SpeedBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::RUN);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnSprint(): SpeedBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::SPRINT);
    }

    /**
     * @param string $movementType
     * @return Time|false
     * @throws \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     */
    public function getPeriodForPointOfFatigue($movementType)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $hours = $this->getValue([$movementType], self::HOURS_PER_POINT_OF_FATIGUE);
            if ($hours !== false) {
                return new Time($hours, TimeUnitCode::HOUR, $this->timeTable);
            }
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $minutes = $this->getValue([$movementType], self::MINUTES_PER_POINT_OF_FATIGUE);
            if ($minutes !== false) {
                return new Time($minutes, TimeUnitCode::MINUTE, $this->timeTable);
            }
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $rounds = $this->getValue([$movementType], self::ROUNDS_PER_POINT_OF_FATIGUE);
            if ($rounds !== false) {
                return new Time($rounds, TimeUnitCode::ROUND, $this->timeTable);
            }

            return false;
        } catch (RequiredRowNotFound $exception) {
            throw new Exceptions\UnknownMovementType(
                'Given movement type ' . ValueDescriber::describe($movementType) . ' is not known'
            );
        }
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnWalk(): Time
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCode::WALK);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnRush(): Time
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCode::RUSH);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnRun(): Time
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCode::RUN);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnSprint(): Time
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCode::SPRINT);
    }

    /**
     * @param Endurance $endurance
     * @return TimeBonus
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertThatBonusToTime
     */
    public function getMaximumTimeBonusToSprint(Endurance $endurance): TimeBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new TimeBonus($endurance->getValue(), $this->timeTable);
    }

    /**
     * @param Endurance $endurance
     * @return TimeBonus
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertThatBonusToTime
     */
    public function getRequiredTimeBonusToWalkAfterFullSprint(Endurance $endurance): TimeBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new TimeBonus($endurance->getValue() + 20, $this->timeTable);
    }

}