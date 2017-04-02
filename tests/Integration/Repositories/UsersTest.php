<?php

namespace Tests\Integration\Repositories;

use Afrittella\BackProject\Repositories\Users;

use Tests\TestCase;
use Tests\Integration\Repositories\Support\EntitiesHelper;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;


class UsersTest extends TestCase
{
    use DatabaseMigrations, EntitiesHelper;

    protected $users; // Users repository

    public function setUp()
    {
        parent::setUp();
        $this->users = new Users(new Collection());
    }

    public function testCanGetAll()
    {
        $this->createUsers();

        $this->assertTrue(count($this->users->all()) > 1);
    }

    public function testCanFind()
    {
        $rightUser = $this->createUser();

        $user = $this->users->find($rightUser->id);

        $this->assertEquals($rightUser->id, $user->id);
    }

    public function testCanFindBy()
    {
        $rightUser = $this->createUser();

        $user = $this->users->findBy('id', 1);

        $this->assertEquals($rightUser->id, $user->id);

        $user = $this->users->findBy('username', 'afrittella');

        $this->assertEquals($rightUser->id, $user->id);
    }

    public function testCanPaginate()
    {
        $this->createMoreUsers(20);

        $this->assertCount(15, $this->users->paginate());
    }

    public function testCanUpdate()
    {
        $user = $this->createUser();

        $this->assertDatabaseMissing('users', [
            'username' => 'afrittella_modified'
        ]);

        $data = [
            'username' => 'afrittella_modified'
        ];

        $this->users->update($data, $user->id);

        $this->assertDatabaseHas('users', [
           'username' => 'afrittella_modified'
        ]);
    }

    public function testCanDelete()
    {
        $user = $this->createUser();

        $this->users->delete($user->id);

        $this->assertDatabaseMissing('users', [
            'username' => 'afrittella'
        ]);
    }
}