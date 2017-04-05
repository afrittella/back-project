<?php

namespace Tests;

//use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class OriginalTestCase extends BaseTestCase
{
    //use CreatesApplication;

    protected function getPackageProviders($app)
    {
        return [
            \Afrittella\BackProject\BackProjectServiceProvider::class,
            //'Orchestra\Database\ConsoleServiceProvider'
        ];
    }
}
