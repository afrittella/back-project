<?php namespace Afrittella\BackProject\Traits;

use Afrittella\BackProject\Models\Attachment;
use Afrittella\BackProject\Traits\Attachable;

trait HasManyAttachments {
    use Attachable;

    /**
     * Gel all attachments for this model
     *
     *  @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */

    /*
     * Indicates if is a one to many relation or one to one
     */
    protected $multi = true;

    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachable')->orderBy('is_main', 'desc');
    }
}
