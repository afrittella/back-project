<?php namespace Afrittella\BackProject\Traits;

use Afrittella\BackProject\Models\Attachment;
use Illuminate\Support\Facades\Auth;

trait Attachable
{

    public static function boot()
    {
        parent::boot();

        // When we delete a model, are deleted also 'attachables' records
        static::deleting(function($model) {
            $model->attachments()->sync([]);
        });
    }

    public function addAttachment($data = [], $user_id = null)
    {
        if (empty($user_id)) {
            if ($user = Auth::user()) {
                $user_id = $user->id;
            }
        }

        // If morphOne attachment, and one attachment is present, we must delete it
        if (!$this->multi and $this->hasAttachments()) {
            $this->deleteAttachment($this->getAttachment());
        }

        return $this->attachments()->create(array_merge($data, ['user_id' => $user_id]));
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