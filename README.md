[![Build Status](https://travis-ci.org/jaroslavtyc/drd-plus-tables.svg?branch=master)](https://travis-ci.org/jaroslavtyc/drd-plus-tables)

Table is optional. Measurement is what made it real.

Bonus, if has sense, is expressed by an entity.

Measurement HAS TO exists (except for base of wounds, which is for numerical transpose only)
Measurement HAS TO implement MeasurementInterface
Measurement HAS TO be able to give its current unit
Measurement MAY be multi-unit
    IF Measurement is multi-unit
        it HAS TO be able to get new self with any of those units
Measurement MAY be based on Bonus
    IF Measurement has Bonus,
        it HAS TO implement MeasurementWithBonusInterface
        and it HAS TO be able to get equivalent Bonus and Bonus has to be able to get equivalent Measurement
    Every Bonus HAS TO have getter (getFoo) for related Measurement
    Every Measurement with Bonus HAS TO have getter (getBar) for related Bonus
Measurement MAY use Table
Measurement MAY use a Bonus and a Table at once
    IF Measurement has a Bonus and a Table,
        than that Table HAS to have Measurement converter to Bonus (recommended toBonus)
        and Bonus converter to Measurement (recommended toFoo)

Measurement MAY provide conversion helper-methods to value in different unit (but HAS TO provide getter for Measurement in that unit)
Table SHOULD NOT has conversion methods different that for Measurement to Bonus and vice versa
Bonus SHOULD NOT has conversion methods different that related Measurement getter

Measurement type MAY has own Exceptions
    IF Measurement type has own Exceptions, those HAVE TO follow exception hierarchy

Note: *Price* and *Base of wounds* are special cases.
