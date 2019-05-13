<?php

namespace App\Http\Requests\DepartmentAdmin;

use Illuminate\Foundation\Http\FormRequest;

class UserManagementRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'avatar' => 'mimes:jpeg,png,bmp,gif,svg,jpg|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => "Bạn vui lòng nhập email",
            'email.email' => "Vui lòng nhập đúng định dạng email",
            'password.required' => "Vui lòng nhập mật khẩu",
            'name.required' => "Vui lòng nhập họ tên",
            'address.required' => "Vui lòng nhập địa chỉ",
            'phone.required' => "Vui lòng nhập số điện thoại",
            'phone.numeric' => "Số điện thoại chỉ bao gồm số",
            'avatar.mimes' => "Ảnh đại diện phải là một tệp loại: jpeg, png, bmp, gif, svg, jpg.",
            'avatar.max' => 'giới hạn upload file là 10 MB',
        ];
    }
}
