<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PermissionRequest extends FormRequest
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
        return [
            'name' => 'required|max:120|min:2',
            'description' => 'required|max:200|min:2',
            
        ];
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
            'name.required' => 'وارد کردن نام   الزامی است',
            'name.min' => 'نام   باید حداقل  2 کارکتر باشد',
            'name.max' => 'نام   باید  حداکثر  120 کارکتر باشد',
            'name.regex' => 'فرمت نام   نامعتبر می باشد',
            'description.required' => 'وارد کردن توضیحات الزامی است',
            'description.min' => 'توضیحات   باید حداقل  2 کارکتر باشد',
            'description.max' => 'توضیحات   باید  حداکثر  200 کارکتر باشد',
            'description.regex' => 'فرمت نام   نامعتبر می باشد',
            
        ];
    }
}
