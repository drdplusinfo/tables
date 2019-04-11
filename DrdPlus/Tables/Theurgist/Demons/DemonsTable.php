<?php
namespace DrdPlus\Tables\Theurgist\Demons;

use DrdPlus\Tables\Partials\AbstractFileTable;

/**
 * @link https://theurg.drdplus.info/#seznam_demonu_dle_skupin_a_sfer
 */
class DemonsTable extends AbstractFileTable
{
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/demons.csv';
    }

    public const REALM = 'realm';
    public const EVOCATION = 'evocation';
    public const BODY = 'body';
    public const KIND = 'kind';
    public const REALMS_AFFECTION = 'realms_affection';
    public const WILL = 'will';
    public const DIFFICULTY = 'difficulty';
    public const TRAITS = 'traits';
    public const CAPACITY = 'capacity';
    public const ENDURANCE = 'endurance';
    public const SPELL_SPEED = 'spell_speed';
    public const QUALITY = 'quality';
    public const DURATION = 'duration';
    public const SPELL_RADIUS = 'spell_radius';
    public const STRENGTH = 'strength';
    public const AGILITY = 'agility';
    public const KNACK = 'knack';
    public const ARMOR = 'armor';
    public const INVISIBILITY = 'invisibility';

    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            self::REALM => self::STRING,
            self::EVOCATION => self::ARRAY,
            self::BODY => self::STRING,
            self::KIND => self::STRING,
            self::REALMS_AFFECTION => self::ARRAY,
            self::WILL => self::INTEGER,
            self::DIFFICULTY => self::ARRAY,
            self::TRAITS => self::ARRAY,
            self::CAPACITY => self::ARRAY,
            self::ENDURANCE => self::ARRAY,
            self::SPELL_SPEED => self::ARRAY,
            self::QUALITY => self::ARRAY,
            self::DURATION => self::ARRAY,
            self::SPELL_RADIUS => self::ARRAY,
            self::STRENGTH => self::ARRAY,
            self::AGILITY => self::ARRAY,
            self::KNACK => self::ARRAY,
            self::ARMOR => self::ARRAY,
            self::INVISIBILITY => self::ARRAY,

        ];
    }

    public const DEMON = 'demon';

    protected function getRowsHeader(): array
    {
        return [self::DEMON];
    }



}