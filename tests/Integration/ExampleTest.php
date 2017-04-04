<?php
namespace Tests\Integration;

use Tests\TestCase;

class ExampleTest extends TestCase
{

    public function testExample()
    {
        $this->assertTrue(true);
        //var_dump(\DB::select("SHOW COLUMNS FROM users"));
        //var_dump(\DB::select("PRAGMA table_info('social_accounts')"));
    }
}