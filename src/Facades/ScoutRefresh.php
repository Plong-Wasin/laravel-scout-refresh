<?php

namespace Wasinpwg\ScoutRefresh\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wasinpwg\ScoutRefresh\ScoutRefresh
 */
class ScoutRefresh extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Wasinpwg\ScoutRefresh\ScoutRefresh::class;
    }
}
