<?php

namespace Afrittella\BackProject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Afrittella\BackProject\Repositories\Permissions;
use Illuminate\Container\Container as App;

class PermissionEdit extends FormRequest
{
    protected $permissions;
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null, Permissions $permissions)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->permissions = $permissions;
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

        //$permissionRepository = new PermissionRepository($this->app);
        $permission = $this->permissions->findBy('id', $this->route('permission'));

        return [
            'name' => 'required|max:255|unique:permissions,name,'.$permission->id,
        ];
    }
}
