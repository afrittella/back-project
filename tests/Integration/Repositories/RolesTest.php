<?php

namespace Tests\Integration\Repositories;

use Afrittella\BackProject\Repositories\Roles;
use Afrittella\BackProject\Repositories\Permissions;

use Tests\TestCase;
use Tests\Integration\Repositories\Support\EntitiesHelper;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;

class RolesTest extends TestCase
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
        $role = $this->createRole();

        $this->assertDatabaseHas('roles', [
           'name' => 'administrator'
        ]);

        $this->assertTrue($role->hasPermissionTo('admin'));
    }
}