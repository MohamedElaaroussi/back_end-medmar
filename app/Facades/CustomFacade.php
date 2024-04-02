<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CustomAppFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'custom-service';
    }
}
