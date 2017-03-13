<?php

namespace Afrittella\BackProject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Afrittella\BackProject\Repositories\Users;
use Illuminate\Container\Container as App;

class UserEdit extends FormRequest
{
    protected $users;
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null, Users $users)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->users = $users;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        //$userRepository = new UserRepository($this->app);
        $user = $this->users->findBy('id', $this->route('user'));

        return [
            'username' => 'required|max:255|unique:users,username,'.$user->id,
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        ];
    }
}
