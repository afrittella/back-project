<?php
namespace Afrittella\BackProject\Repositories\Criteria\Attachments;

use Afrittella\BackProject\Repositories\Criteria\Criteria;
use Afrittella\BackProject\Contracts\BaseRepository as  Repository;
use Illuminate\Support\Facades\Auth;

class ByUser extends Criteria {
    protected $user_id;

    public function __construct($user_id = null)
    {
        if (!is_null($user_id)) {
            $this->user_id = $user_id;
        } else {
            $this->user_id = Auth::user()->id;
        }
    }

    public function apply($model, Repository $repository)
    {
        $query = $model->where('user_id', '=', $this->user_id)->orderBy('is_main', 'desc')->orderBy('created_at', 'desc');
        return $query;
    }
}