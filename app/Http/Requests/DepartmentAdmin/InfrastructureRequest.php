<?php

namespace App\Http\Requests\DepartmentAdmin;

use Illuminate\Foundation\Http\FormRequest;

class InfrastructureRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'picture' => 'required|file|mimes:xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Vui lòng nhập tên tài sản",
            'name.max' => 'Tên tài sản chỉ được nhập tối đa 100 ký tự',
            'picture.required' => "Vui lòng chọn file  để upload",
            'picture.mimes' => "File Upload phải là một tệp loại: xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff.",
            'amount.required' => "Vui lòng nhập số lượng",
            'amount.numeric' => "Vui lòng nhập trường số lượng là kí tự số",
            'picture.max' => 'giới hạn upload file là 10 MB',
        ];
    }
}
