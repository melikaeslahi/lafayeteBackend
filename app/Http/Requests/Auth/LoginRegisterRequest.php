<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRegisterRequest extends FormRequest
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
            'id' => 'required|min:11|max:64|regex:/^[a-zA-Z0-9_.@\+]*$/'
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
            'id.required' => 'وارد کردن   شماره ی موبایل با آدرس ایمیل  الزامی است',
            'id.min' => 'شماره ی موبایل یا ادرس ایمیل  حداقل 11  کارکتر است',
            'id.max' => 'آدرس ایمیل باید حداکثر 64 کارکتر باشد',
            'id.regex' => ' فرمت ایمیل یا شماره موبایل اشتباه است ',

            
        ];
    }
}
