<?php
namespace DrdPlus\Tables\Races;

use Granam\Strict\Object\StrictObject;

class RaceTables extends StrictObject
{
    /**
     * @var FemaleModifiersTable|null
     */
    private $femaleModifiersTable;
    /**
     * @var RacesTable|null
     */
    private $racesTable;
    /**
     * @var SizeAndWeightTable|null
     */
    private $sizeAndWeightTable;

    /**
     * @return FemaleModifiersTable
     */
    public function getFemaleModifiersTable()
    {
        if (isset($this->femaleModifiersTable)) {
            return $this->femaleModifiersTable;
        }

        return $this->femaleModifiersTable = new FemaleModifiersTable();
    }

    /**
     * @return RacesTable|null
     */
    public function getRacesTable()
    {
        if (isset($this->racesTable)) {
            return $this->racesTable;
        }

        return $this->racesTable = new RacesTable();
    }

    /**
     * @return SizeAndWeightTable|null
     */
    public function getSizeAndWeightTable()
    {
        if (isset($this->sizeAndWeightTable)) {
            return $this->sizeAndWeightTable;
        }

        return $this->sizeAndWeightTable = new SizeAndWeightTable();
    }
}
