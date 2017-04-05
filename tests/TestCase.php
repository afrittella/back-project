<?php

namespace Tests;

//use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    //use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations('testing');
        $this->loadMigrationsFrom([
           '--database' => 'testing'
        ]);
        $this->artisan('migrate', ['--database' => 'testing']);

        //$this->artisan('migrate', ['--database' => 'testing']);
        /*$this->loadMigrationsFrom([
          __DIR__.'/../../src/database/migrations'
        ]);
        $this->artisan('migrate', ['--database' => 'testing']);*/
        /*$this->loadMigrationsFrom([
          '--database' => 'testing',
          '--realpath' => __DIR__.'/../../src/database/migrations',
        ]);*/

    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'mysql',
            'host' => env('TRAVIS_HOST', 'mariadb'),
            'database' => 'family_test',
            'prefix'   => '',
            'username' => 'test',
            'password' => 'test',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
          \Afrittella\BackProject\BackProjectServiceProvider::class,
          //'Orchestra\Database\ConsoleServiceProvider'
        ];
    }
}
