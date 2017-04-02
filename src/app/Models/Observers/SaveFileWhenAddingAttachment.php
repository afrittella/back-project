<?php namespace Afrittella\BackProject\Models\Observers;

use Illuminate\Http\Request;
use Afrittella\BackProject\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Afrittella\BackProject\Facades\MediaManager;

class SaveFileWhenAddingAttachment
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        //$this->media_path = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
    }

    public function creating(Attachment $attachment)
    {
        $file = $this->request->file('attachment');

        if (!empty($file)) {
            $img_name = MediaManager::hashName($file->getClientOriginalExtension());
            if (Storage::put($img_name, file_get_contents($file->getRealPath()), ['visibility' => 'public'])) {
                $attachment->name = $img_name;
                $attachment->original_name = $file->getClientOriginalName();
                return true;
            } else {
                return false;
            }
            /*if ($path = $file->storeAs('', $img_name,['visibility' => 'public'])) {
                $attachment->name = $path;
                $attachment->original_name = $file->getClientOriginalName();
                return true;
            } else {
                return false;
            }*/
        }
    }
}
