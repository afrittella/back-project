<?php
namespace Afrittella\BackProject\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider_user_info', 'provider'];

    public function user()
    {
        return $this->belongsTo(config('back-project.user_model'));
    }
}