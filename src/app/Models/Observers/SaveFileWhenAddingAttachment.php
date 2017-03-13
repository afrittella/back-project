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
        $this->media_path = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
    }

    public function creating(Attachment $attachment)
    {
        $file = $this->request->file('attachment');

        // @TODO
        /*if (empty($file)) {
            $image = Gravatar::get($this->request->input('email'), ['size' => 500]);
            //$img_name = str_random(32).'.jpg';
            $img_name = MediaManager::hashName('jpg');
            $img =  $this->media_path . '/' . $img_name;
            file_put_contents($img, file_get_contents($image));
            $attachment->name = $img_name;
            $attachment->original_name = "gravatar.jpg";
            return true;
        }*/

        //$img_name = str_random(32).'.'.$file->extension();
        if (!empty($file)) {
            $img_name = MediaManager::hashName($file->extension());

            if ($path = $file->storeAs('', $img_name,['visibility' => 'public'])) {
                $attachment->name = $path;
                $attachment->original_name = $file->getClientOriginalName();
                return true;
            } else {
                return false;
            }
        }
    }
}
