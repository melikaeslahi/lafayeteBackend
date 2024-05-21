<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class GalleryStoreRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg'
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
            
            'image.required' => 'وارد کردن تصویر الزامی است',
            'image.image' => 'فایل وارد شده باید تصویر باشد',
            'image.mimes' => 'فرمت تصویر اشتباه است',            
             
        ];
    }
}
