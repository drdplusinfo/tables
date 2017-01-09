<?php
namespace DrdPlus\Tables\Riding;

use DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents;
use DrdPlus\Tables\Partials\Percents;
use Granam\Tools\ValueDescriber;

class DefianceOfWildPercents extends Percents
{
    /**
     * @param mixed $value
     * @throws \DrdPlus\Tables\Riding\Exceptions\UnexpectedDefianceOfWildPercents
     */
    public function __construct($value)
    {
        try {
            parent::__construct($value);
        } catch (UnexpectedPercents $unexpectedPercents) {
            throw new Exceptions\UnexpectedDefianceOfWildPercents($unexpectedPercents->getMessage());
        }
        if ($this->getValue() > 100) {
            throw new Exceptions\UnexpectedDefianceOfWildPercents(
                'Expected percents of defiance for wild animal to be from zero to one hundred, got '
                . ValueDescriber::describe($value)
            );
        }
    }
}