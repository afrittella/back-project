<?php namespace Afrittella\BackProject\Models\Observers;

use Illuminate\Http\Request;
use Afrittella\BackProject\Models\Attachment;
use Illuminate\Support\Facades\DB;

class RemoveAttachableWheDeletingAttachment
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     *  When we remove attachment, we must delete all "attachables" reference
     * @param Attachment $attachment
     */
    public function deleting(Attachment $attachment)
    {
        DB::table('attachables')->where('attachment_id', '=', $attachment->id)->delete();
    }
}
