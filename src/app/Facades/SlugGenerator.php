<?php namespace Afrittella\BackProject\Facades;

use Illuminate\Support\Facades\Facade;

class SlugGenerator extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'slug-generator';
    }
}
