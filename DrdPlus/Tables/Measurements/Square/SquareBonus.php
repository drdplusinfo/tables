<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Square;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

class SquareBonus extends AbstractBonus
{
    /** @var SquareTable */
    private $squareTable;

    /**
     * @param \Granam\Integer\IntegerInterface|int $value
     * @param SquareTable $squareTable
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    public function __construct($value, SquareTable $squareTable)
    {
        parent::__construct($value);
        $this->squareTable = $squareTable;
    }

    /**
     * @return Square
     */
    public function getSquare(): Square
    {
        return $this->squareTable->toSquare($this);
    }

}