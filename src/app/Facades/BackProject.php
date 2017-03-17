<?php namespace Afrittella\BackProject\Facades;

use Illuminate\Support\Facades\Facade;

class BackProject extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'back-project';
    }
}
