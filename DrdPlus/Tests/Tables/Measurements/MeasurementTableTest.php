<?php
namespace DrdPlus\Tests\Tables\Measurements;

interface MeasurementTableTest
{
    public function I_can_get_headers();

    public function I_can_convert_bonus_to_value();

    public function I_can_not_use_too_low_bonus_to_value();

    public function I_can_convert_value_to_bonus();

    public function I_can_not_convert_too_high_bonus_to_value();

    public function I_can_not_convert_too_low_value_to_bonus();

    public function I_can_not_convert_too_high_value_to_bonus();

}