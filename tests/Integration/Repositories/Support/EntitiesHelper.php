<?php
/**
 * Created by PhpStorm.
 * User: andreafrittella
 * Date: 01/04/17
 * Time: 21:58
 */

namespace Tests\Integration\Repositories\Support;

use Faker\Factory;

trait EntitiesHelper
{
    public function createUser()
    {
        return $this->users->create([
            'username' => 'afrittella',
            'email' => 'a.frittella@test.it',
            'password' => 'password',
            'confirmed' => 1,
            'is_social' => 0
        ]);
    }

    public function createUsers()
    {
        $this->users->create([
            'username' => 'afrittella',
            'email' => 'a.frittella@test.it',
            'password' => 'password',
            'confirmed' => 1,
            'is_social' => 0
        ]);

        $this->users->create([
            'username' => 'afrittella2',
            'email' => 'a.frittella2@test.it',
            'password' => 'password',
            'confirmed' => 0,
            'is_social' => 1
        ]);
    }

    public function createMoreUsers($number)
    {
        $faker = Factory::create();

        for ($i = 0; $i < $number; $i++) {
            $this->users->create([
                'username' => $faker->userName,
                'email' => $faker->safeEmail,
                'password' => $faker->password,
                'confirmed' => $faker->randomElement([0, 1], 1),
                'is_social' => $faker->randomElement([0, 1], 1),
            ]);
        }
    }

    public function createRole()
    {
        $this->permissions->create([
            'name' => 'admin'
        ]);

        return $this->roles->create([
            'name' => 'administrator',
            'permissions' => [1]
        ]);
    }

    public function createPermission()
    {
        $this->roles->create([
            'name' => 'administrator'
        ]);

        return $this->permissions->create([
            'name' => 'admin',
            'roles' => [1]
        ]);
    }

    public function createAttachments()
    {
        $this->createUsers();

        $faker = Factory::create();

        $this->attachments->create([
            'id' => 1,
            'name' => 'test_attachment',
            'original_name' => 'test_attachment',
            'is_main' => 1,
            'user_id' => 1
        ]);

        for ($i = 0; $i < 10; $i++) {
            $this->attachments->create([
                'name' => $faker->uuid,
                'original_name' => $faker->uuid,
                'is_main' => 1, // Force all main
                'user_id' => $faker->randomElement([1, 2], 1),
            ]);
        }
    }
}
