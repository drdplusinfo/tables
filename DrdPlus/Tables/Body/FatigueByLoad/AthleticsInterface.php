<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Body\FatigueByLoad;

use Granam\Integer\IntegerInterface;

interface AthleticsInterface
{
    /**
     * @return IntegerInterface
     */
    public function getAthleticsBonus();
}