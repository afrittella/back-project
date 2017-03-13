<?php
namespace Afrittella\BackProject\Repositories\Criteria;

use Afrittella\BackProject\Repositories\Criteria\Criteria;
use Afrittella\BackProject\Contracts\BaseRepository as  Repository;
use Illuminate\Support\Facades\Auth;

class ByUser extends Criteria {
    public function apply($model, Repository $repository)
    {
        $query = $model->where('user_id', '=', Auth::user()->id);
        return $query;
    }
}