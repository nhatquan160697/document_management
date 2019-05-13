<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeAvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar' => 'mimes:jpeg,png,bmp,gif,svg,jpg|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' => "Ảnh đại diện phải là một tệp loại: jpeg, png, bmp, gif, svg, jpg.",
            'avatar.max' => 'giới hạn upload file là 10 MB',
        ];
    }
}
