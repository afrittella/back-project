<?php

namespace Afrittella\BackProject\Http\Requests;

use Afrittella\BackProject\Repositories\Menus;
use Illuminate\Foundation\Http\FormRequest;

class MenuEdit extends FormRequest
{
    protected $menus;
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null, Menus $menus)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->menus = $menus;
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
        $menu = $this->menus->find($this->route('menu'));

        return [
            'name' => 'required|max:255|unique:menus,name,'.$menu->id,
            'title' => 'required|max:255',
        ];
    }
}
