<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRegisterConfirmRequest extends FormRequest
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
            'otp' => 'required|min:6|max:6'
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
            'otp.required' => 'وارد کردن     کد تایید الزامی است',
            'otp.min' => 'کد تایید باید حداقل 6 رقم  باشد',
            'otp.max' => '    کد تایید باید  حداکثر   6  رقم  باشد',
            
        ];
    }
}
