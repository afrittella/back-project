<?php namespace Afrittella\BackProject\Traits;

use Afrittella\BackProject\Models\Attachment;
use Afrittella\BackProject\Traits\Attachable;

/**
 * MorphToOne relation
 */
trait HasOneAttachment {
    use Attachable;
    /*
     * Indicates if is a one to many relation or one to one
     */
    protected $multi = false;

    /**
     * Gel attachment for this model
     *
     *  @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachable')->orderBy('is_main', 'desc');
    }

    public function getAttachment() {
        return $this->attachments()->first();
    }
}
