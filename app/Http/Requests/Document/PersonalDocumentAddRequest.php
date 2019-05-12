<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class PersonalDocumentAddRequest extends FormRequest
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
            'document_number' => 'required|max:255|unique:documents',
            'document_type_id' => 'required',
            'publish_date' => 'required',
            'content' => 'required|max:500',
            'attachedFiles.*' => 'required|file|mimes:xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff',
        ];
    }

    public function messages()
    {
        return [
            'document_number.required' => 'Vui lòng nhập số văn bản',
            'document_number.max' => 'Chỉ được nhập tối đa 255 ký tự',
            'document_number.unique' => 'Số văn bản đã tồn tại',
            'document_type_id.required' => 'Vui lòng chọn loại văn bản',
            'publish_date.required' => 'Vui lòng chọn ngày ban hành',
            'content.required' => 'Vui lòng nhập trích yếu nội dung',
            'content.max' => 'Chỉ được nhập tối đa 400 ký tự',
            'attachedFiles.required' => 'Vui lòng chọn file đính kèm',
            'attachedFiles.file' => 'Vui lòng chọn file đính kèm',
            'attachedFiles.mimes' => "File Upload phải là một tệp loại: xlsx,xls,csv,jpg,jpeg,png,bmp,doc,docx,pdf,tif,tiff.",
        ];
    }
}
