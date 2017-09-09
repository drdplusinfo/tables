<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Tools;

interface EvaluatorInterface
{

    /**
     * @param int $maxRollToGetValue
     * @return int
     */
    public function evaluate($maxRollToGetValue);
}