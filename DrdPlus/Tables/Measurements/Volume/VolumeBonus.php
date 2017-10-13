<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Volume;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

class VolumeBonus extends AbstractBonus
{
    /** @var VolumeTable */
    private $volumeTable;

    /**
     * @param \Granam\Integer\IntegerInterface|int $value
     * @param VolumeTable $volumeTable
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    public function __construct($value, VolumeTable $volumeTable)
    {
        parent::__construct($value);
        $this->volumeTable = $volumeTable;
    }


    /**
     * @return Volume
     */
    public function getVolume(): Volume
    {
        return $this->volumeTable->toVolume($this);
    }

}