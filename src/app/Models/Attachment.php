<?php namespace Afrittella\BackProject\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //use SoftDeletes;

    protected $fillable = ['name', 'original_name', 'description', 'user_id', 'is_main'];
    //protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(config('back-project.user_model'));
    }
}
