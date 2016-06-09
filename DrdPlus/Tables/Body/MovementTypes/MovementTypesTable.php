<?php
namespace DrdPlus\Tables\Body\MovementTypes;

use DrdPlus\Codes\MovementTypeCodes;
use DrdPlus\Properties\Derived\Endurance;
use DrdPlus\Tables\Measurements\Speed\SpeedBonus;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeBonus;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

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

    public function __construct(SpeedTable $speedTable, TimeTable $timeTable)
    {
        $this->speedTable = $speedTable;
        $this->timeTable = $timeTable;
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/movement_types.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return [
            'movement_type'
        ];
    }

    const BONUS_TO_MOVEMENT_SPEED = 'bonus_to_movement_speed';
    const HOURS_PER_POINT_OF_FATIGUE = 'hours_per_point_of_fatigue';
    const MINUTES_PER_POINT_OF_FATIGUE = 'minutes_per_point_of_fatigue';
    const ROUNDS_PER_POINT_OF_FATIGUE = 'rounds_per_point_of_fatigue';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::BONUS_TO_MOVEMENT_SPEED => self::INTEGER,
            self::HOURS_PER_POINT_OF_FATIGUE => self::FLOAT,
            self::MINUTES_PER_POINT_OF_FATIGUE => self::FLOAT,
            self::ROUNDS_PER_POINT_OF_FATIGUE => self::FLOAT,
        ];
    }

    /**
     * @param string $movementType
     * @return SpeedBonus
     * @throws \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     */
    public function getSpeedBonus($movementType)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return new SpeedBonus($this->getValue([$movementType], self::BONUS_TO_MOVEMENT_SPEED), $this->speedTable);
        } catch (RequiredRowDataNotFound $exception) {
            throw new Exceptions\UnknownMovementType(
                'Given movement type is not known ' . ValueDescriber::describe($movementType)
            );
        }
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnWalk()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(MovementTypeCodes::WALK);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnRush()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(MovementTypeCodes::RUSH);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnRun()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(MovementTypeCodes::RUN);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnSprint()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(MovementTypeCodes::SPRINT);
    }

    /**T
     * @param string $movementType
     * @return Time
     * @throws \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     */
    public function getPeriodForPointOfFatigue($movementType)
    {
        try {
            $timeTable = new TimeTable();
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $hours = $this->getValue([$movementType], self::HOURS_PER_POINT_OF_FATIGUE);
            if ($hours !== false) {
                return new Time($hours, Time::HOUR, $timeTable);
            }
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $minutes = $this->getValue([$movementType], self::MINUTES_PER_POINT_OF_FATIGUE);
            if ($minutes !== false) {
                return new Time($minutes, Time::MINUTE, $timeTable);
            }
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $rounds = $this->getValue([$movementType], self::ROUNDS_PER_POINT_OF_FATIGUE);

            return new Time($rounds, Time::ROUND, $timeTable);
        } catch (RequiredRowDataNotFound $exception) {
            throw new Exceptions\UnknownMovementType(
                'Given movement type is not known ' . ValueDescriber::describe($movementType)
            );
        }
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnWalk()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCodes::WALK);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnRush()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCodes::RUSH);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnRun()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCodes::RUN);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnSprint()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCodes::SPRINT);
    }

    /**
     * @param Endurance $endurance
     * @return TimeBonus
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertThatBonusToTime
     */
    public function getMaximumTimeBonusToSprint(Endurance $endurance)
    {
        return new TimeBonus($endurance->getValue(), $this->timeTable);
    }

    /**
     * @param Endurance $endurance
     * @return TimeBonus
     * @throws \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertThatBonusToTime
     */
    public function getRequiredTimeBonusToWalkAfterFullSprint(Endurance $endurance)
    {
        return new TimeBonus($endurance->getValue() + 20, $this->timeTable);
    }

}