<?php namespace Afrittella\BackProject\Models\Observers;

use Illuminate\Http\Request;
use Afrittella\BackProject\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class RemoveFileWhenDeletingAttachment
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function deleting(Attachment $attachment)
    {
        Storage::delete($attachment->name);
    }
}
