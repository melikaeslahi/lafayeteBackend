<?php

namespace App\Http\Requests\Admin\Notify;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmailFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')) {
            return [
            
                'file_path' => 'required|mimes:png,jpg,jpeg,gif,pdf,docx,doc,zp',
                'status' => 'required|numeric|in:0,1',
            
            

            ];
        }else{
            return [
             
                'file_path' => 'mimes:png,jpg,jpeg,gif,pdf,docx,doc,zp',
                'status' => 'required|numeric|in:0,1',
            

                
            ];
        }
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'message' => 'error validation',
                'errors' => $validator->errors()
            ]
        ));
    }

    public function messages()
    {
        return [
            
            'file_path.required' => 'وارد کردن  فایل ایمیل الزامی است',
            'file_path.mimes' => 'فرمت  فایل اشتباه است',
            'status.required' => 'وارد کردن وضعیت برای دسته الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت دسته بندی نامعتبر است',
             
        ];
    }
}
