<?php
namespace DrdPlus\Tables\Measurements\Weight;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use Granam\Tools\ValueDescriber;

class MalusFromLoad extends AbstractBonus
{
    /**
     * @param int $value
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     * @throws \DrdPlus\Tables\Measurements\Weight\Exceptions\MalusFromLoadCanNotBePositive
     */
    public function __construct($value)
    {
        parent::__construct($value);
        if ($this->getValue() > 0) {
            throw new Exceptions\MalusFromLoadCanNotBePositive(
                'Malus from load has to be zero or negative number, got ' . ValueDescriber::describe($value)
            );
        }
    }

}