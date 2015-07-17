<?php
namespace DrdPlus\Tables;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;

class DiceChanceEvaluator implements EvaluatorInterface
{
    /**
     * @var Roll1d6
     */
    private $roll1d6;

    public function __construct(Roll1d6 $roll1d6)
    {
        $this->roll1d6 = $roll1d6;
    }

    /**
     * @param int $maxRollToGetValue
     *
     * @return int
     */
    public function evaluate($maxRollToGetValue)
    {
        if ($maxRollToGetValue <= $this->roll1d6->roll()) {
            return 1;
        }

        return 0;
    }

}
