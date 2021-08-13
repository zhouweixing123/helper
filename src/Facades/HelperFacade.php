<?php

namespace Zwx\Helper\Facades;

use Illuminate\Support\Facades\Facade;

class HelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'helperFunc';
    }
}
