<?php

namespace andcarpi\Popper\Facades;

use Illuminate\Support\Facades\Facade;

class Popper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'popper';
    }
}
