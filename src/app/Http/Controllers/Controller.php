<?php

namespace Afrittella\BackProject\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Custom authorization method. Use only if you are managing a model with "user_id" field
     *
     * @param $ability
     * @param array $record
     */
    public function bCAuthorize($ability, $record = [])
    {
        if ($record->user_id !== Auth::user()->id) {
            abort(403);
        }
    }
}
