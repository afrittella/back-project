<?php

namespace Tests\Integration\Repositories;

use Afrittella\BackProject\Repositories\Permissions;
use Afrittella\BackProject\Repositories\Roles;

use Tests\TestCase;
use Tests\Integration\Repositories\Support\EntitiesHelper;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;

class PermissionsTest extends TestCase
{
    use DatabaseMigrations, EntitiesHelper;

    protected $roles;
    protected $permissions;

    public function setUp()
    {
        parent::setUp();
        $this->roles = new Roles(new Collection());
        $this->permissions = new Permissions(new Collection());
    }

    public function testCanCreate()
    {
        $permission = $this->createPermission();

        $this->assertDatabaseHas('permissions', [
           'name' => 'admin'
        ]);
    }
}