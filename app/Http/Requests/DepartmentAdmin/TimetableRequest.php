<?php

namespace App\Http\Requests\DepartmentAdmin;

use Illuminate\Foundation\Http\FormRequest;

class TimetableRequest extends FormRequest
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
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'file_attachment.*' => 'required|file|mimes:xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Vui lòng nhập tiêu đề",
            'name.max' => 'Tiêu đề chỉ được nhập tối đa 100 ký tự',
            'file_attachment.required' => "Vui lòng chọn file  để upload",
            'file_attachment.*.mimes' => "File Upload phải là một tệp loại: xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff.",
            'description.required' => "Vui lòng nhập mô tả",
            'description.max' => "Mô tả chỉ được nhập tối đa 255 ký tự",
            'file_attachment.*.max' => 'giới hạn upload file là 10 MB',
        ];
    }
}
