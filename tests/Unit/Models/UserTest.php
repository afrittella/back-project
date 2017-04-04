<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    

    protected $userModel;

    public function setUp()
    {
        parent::setUp();

        $this->userModel = config('back-project.user_model');
    }

    public function testIfIsConfirmed()
    {
        $user = $this->addUser(1);

        $this->assertTrue($user->isConfirmed());
    }

    public function testIfHasConfirmationCode()
    {
        $user = $this->addUser(0);

        $this->assertTrue($user->hasConfirmationCode());
    }

    public function testIfIsPendingConfirmation()
    {
        $user = $this->addUser(0);

        $this->assertTrue($user->isPendingConfirmation());
    }

    public function testCanConfirm()
    {
        $user = $this->addUser(0);

        $this->assertTrue($user->confirm('CODE'));
    }

    public function testCannotConfirm()
    {
        $user = $this->addUser(1, true);

        $this->assertFalse($user->confirm('CODE'));
    }

    protected function addUser($confirmed = 1, $save = false)
    {
        $user = new $this->userModel();

        $user->username = 'afrittella';
        $user->email = 'info@info.it';
        $user->password = 'password';
        $user->confirmed = $confirmed;
        $user->confirmation_code = 'CODE';

        if ($save) {
            $user->save();
        }

        return $user;
    }
}
