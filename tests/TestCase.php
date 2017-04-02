<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
//use \Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
