<?php
namespace Tests\Unit\Models\Observers;

use Tests\TestCase;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Afrittella\BackProject\Models\Attachment;
use Afrittella\BackProject\Models\Observers\SaveFileWhenAddingAttachment;

class SaveFileWhenAddingAttachmentTest extends TestCase
{
    private $attachmentMock;
    private $requestMock;
    private $fileMock;

    public function setUp()
    {
        parent::setUp();

        $this->attachmentMock = $this->createMock(Attachment::class);
        $this->requestMock = $this->createMock(Request::class);
        $this->fileMock = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
    }

    public function testUpload()
    {
        $this->fileMock->expects($this->any())
            ->method('getClientOriginalName')
            ->willReturn('original_name');

        $this->fileMock->expects($this->once())
            ->method('getRealPath')
            ->willReturn(tempnam('tmp', 'test'));

        $this->requestMock->expects($this->once())
            ->method('file')
            ->willReturn($this->fileMock);

        \Storage::shouldReceive('put')->once();

        $attachmentUploader = new SaveFileWhenAddingAttachment($this->requestMock);
        $attachmentUploader->creating($this->attachmentMock);
    }
}