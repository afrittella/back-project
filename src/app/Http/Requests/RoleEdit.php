<?php

namespace Afrittella\BackProject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Afrittella\BackProject\Repositories\Roles;
use Illuminate\Container\Container as App;

class RoleEdit extends FormRequest
{
    protected $roles;
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null, Roles $roles)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->roles = $roles;
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

        //$roleRepository = new RoleRepository($this->app);
        $role = $this->roles->findBy('id', $this->route('role'));

        return [
            'name' => 'required|max:255|unique:roles,name,'.$role->id,
        ];
    }
}
