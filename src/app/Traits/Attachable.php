<?php namespace Afrittella\BackProject\Traits;

use Afrittella\BackProject\Models\Attachment;
use Illuminate\Support\Facades\Storage;

trait Attachable
{

    public function addAttachment($data = [])
    {
        // If morphOne attachment, and one attachment is present, we must delete it
        if (!$this->multi and $this->hasAttachments()) {
            $this->deleteAttachment($this->getAttachment());
        }

        $attachment = $this->attachments()->create($data);

        return $attachment->save();
    }

    public function deleteAttachment(Attachment $attachment)
    {
        return $attachment->delete();
    }

    /**
     * Check if model has attachments
     */
    public function hasAttachments()
    {
        return (bool) $this->attachments()->count();
    }
}