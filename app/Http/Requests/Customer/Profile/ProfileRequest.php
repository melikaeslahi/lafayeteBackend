<?php

namespace App\Http\Requests\Customer\Profile;

use App\Rules\NationalCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'first_name' => 'nullable|max:120|min:2|regex:/^[ا-یa-zA-Zء-ي  ]+$/u',
            'last_name' => 'nullable|max:120|min:2|regex:/^[ا-یa-zA-Zء-ي  ]+$/u',
            'email' => ['nullable', 'string', 'email', 'unique:users'],
            'mobile' => ['nullable', 'digits:11', 'unique:users'],
            'national_code' => ['sometimes', 'nullable', new  NationalCode(),    Rule::unique('users')->ignore($this->user()->national_code, 'national_code')],
            'profile_photo_path'=> 'image|mimes:jpg,png,jpeg,gif,svg'
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
            
            'first_name.min' => 'نام   باید حداقل  2 کارکتر باشد',
            'first_name.max' => 'نام   باید  حداکثر  120 کارکتر باشد',
            'first_name.regex' => 'فرمت نام   نامعتبر می باشد',
            
            'last_name.min' => 'نام خانوادگی باید حداقل  2 کارکتر باشد',
            'last_name.max' => 'نام خانوادگی باید  حداکثر  120 کارکتر باشد',
            'last_name.regex' => 'فرمت نام خانوادگی نامعتبر می باشد',
       
            'national_code.mimes' => 'فرمت تصویر اشتباه است',
          
          
            'email.string' => 'آدرس ایمیل باید حروف  باشد',
            'email.email' => ' فرمت ایمیل اشتباه است',
            'email.unique' => ' آدرس ایمیل نباید تکراری باشد',
            
            'mobile.digits' => ' شماره تلفن باید  11 رقم باشد',     
            'mobile.unique' => ' شماره تلفن نباید تکراری باشد',
            // 'password.required' => 'وارد کردن   رمز     الزامی است',
            // 'password.confirmed' => '     تکرار رمز عبور اشتباه است     ',    
            // 'password.unique' => ' رمز ورود نباید تکراری باشد',
        ];
    }
}
