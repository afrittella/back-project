<?php namespace Afrittella\BackProject\Facades;

use Illuminate\Support\Facades\Facade;

class MediaManager extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'attachments-manager';
    }
}
