<?php
namespace Afrittella\BackProject\Repositories\Criteria\Attachments;

use Afrittella\BackProject\Repositories\Criteria\Criteria;
use Afrittella\BackProject\Contracts\BaseRepository as  Repository;
use Illuminate\Support\Facades\Auth;

class All extends Criteria {
    public function apply($model, Repository $repository)
    {
        $query = $model->orderBy('user_id')->orderBy('is_main', 'desc')->orderBy('created_at', 'desc');
        return $query;
    }
}