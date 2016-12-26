<?php
namespace DrdPlus\Tables\Measurements\Tools;

interface EvaluatorInterface
{

    /**
     * @param int $maxRollToGetValue
     * @return int
     */
    public function evaluate($maxRollToGetValue);
}