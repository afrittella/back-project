<?php

namespace Tests\Integration\Repositories;

use Afrittella\BackProject\Repositories\Attachments;
use Afrittella\BackProject\Repositories\Criteria\Attachments\ByUser;
use Afrittella\BackProject\Repositories\Users;

use Tests\TestCase;
use Tests\Integration\Repositories\Support\EntitiesHelper;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;


class AttachmentsTest extends TestCase
{
    use EntitiesHelper;

    protected $attachments; // Users repository

    public function setUp()
    {
        parent::setUp();

        $this->attachments = \App::make(Attachments::class);
        //$this->attachments = new Attachments(new Collection());
        $this->users = \App::make(Users::class);
        //$this->users = new Users(new Collection());
    }

    public function testRemoveIsMain()
    {
        $this->createAttachments();

        $this->attachments->removeIsMain(1, 1);

        $this->attachments->pushCriteria(new ByUser(1));

        $this->assertCount(1, $this->attachments->all()->where('is_main', '=', 1));
    }
}
