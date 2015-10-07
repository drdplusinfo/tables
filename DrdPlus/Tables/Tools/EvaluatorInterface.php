<?php
namespace DrdPlus\Tables\Tools;

interface EvaluatorInterface
{

    /**
     * @param int $maxRollToGetValue
     *
     * @return int
     */
    public function evaluate($maxRollToGetValue);
}
