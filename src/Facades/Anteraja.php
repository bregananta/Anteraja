<?php

namespace Bregananta\Anteraja\Facades;

use Illuminate\Support\Facades\Facade;

class Anteraja extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return "Anteraja";
    }
}