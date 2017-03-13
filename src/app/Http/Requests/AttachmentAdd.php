<?php

namespace Afrittella\BackProject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentAdd extends FormRequest
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
            'attachment' => 'file|max:'.(config('back-project.attachments.max_file_size')*1024).'|mimes:jpg,jpeg,png,gif'
        ];
    }
}
