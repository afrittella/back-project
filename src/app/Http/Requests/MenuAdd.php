<?php

namespace Afrittella\BackProject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuAdd extends FormRequest
{
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
        return [
            'name' => 'required|max:255|unique:menus',
            'title' => 'required|max:255',
        ];
    }
}
