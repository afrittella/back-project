<?php

namespace Tests\Unit\Models\Observers;

use Tests\TestCase;
use Illuminate\Http\Request;

use Afrittella\BackProject\Models\Attachment;
use Afrittella\BackProject\Models\Observers\RemoveFileWhenDeletingAttachment;

class RemoveFileWhenDeletingAttachmentTest extends TestCase
{
    private $attachmentMock;
    private $requestMock;

    public function setUp()
    {
        parent::setUp();

        $this->attachmentMock = $this->createMock(Attachment::class);
        $this->requestMock = $this->createMock(Request::class);
    }

    public function testRemove()
    {
        \Storage::shouldReceive('delete')->once();

        $attachmentUploader = new RemoveFileWhenDeletingAttachment($this->requestMock);
        $attachmentUploader->deleting($this->attachmentMock);
    }
}