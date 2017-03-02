<?php
namespace DrdPlus\Tables\Body\MovementTypes;

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
    public function getSpeedBonusOnWaiting()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::WAITING);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnWalk()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::WALK);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnRush()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::RUSH);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnRun()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSpeedBonus(self::RUN);
    }

    /**
     * @return SpeedBonus
     */
    public function getSpeedBonusOnSprint()
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
                return new Time($hours, Time::HOUR, $this->timeTable);
            }
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $minutes = $this->getValue([$movementType], self::MINUTES_PER_POINT_OF_FATIGUE);
            if ($minutes !== false) {
                return new Time($minutes, Time::MINUTE, $this->timeTable);
            }
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $rounds = $this->getValue([$movementType], self::ROUNDS_PER_POINT_OF_FATIGUE);
            if ($rounds !== false) {
                return new Time($rounds, Time::ROUND, $this->timeTable);
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
    public function getPeriodForPointOfFatigueOnWalk()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCode::WALK);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnRush()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCode::RUSH);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnRun()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCode::RUN);
    }

    /**
     * @return Time
     */
    public function getPeriodForPointOfFatigueOnSprint()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPeriodForPointOfFatigue(MovementTypeCode::SPRINT);
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