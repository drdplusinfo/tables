<?php
namespace DrdPlus\Tables;

interface EvaluatorInterface
{

    /**
     * @param int $maxRollToGetValue
     *
     * @return int
     */
    public function evaluate($maxRollToGetValue);
}
