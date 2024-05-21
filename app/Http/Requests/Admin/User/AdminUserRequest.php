<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class AdminUserRequest extends FormRequest
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
        if ( $this->isMethod('post')) {
            return [
                'first_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Zء-ي  ]+$/u',
                'last_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Zء-ي  ]+$/u',
                'email' => ['required', 'string', 'email', 'unique:users'],
                'mobile' => ['required', 'digits:11', 'unique:users'],
                'password' => ['required', 'unique:users',  Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), 'confirmed'],
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif',
                'activation' => 'required|numeric|in:0,1',
    
            ];
        }else{
            return [
                'first_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Zء-ي  ]+$/u',
                'last_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Zء-ي  ]+$/u',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif',
               
    
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
            'first_name.required' => 'وارد کردن نام   الزامی است',
            'first_name.min' => 'نام   باید حداقل  2 کارکتر باشد',
            'first_name.max' => 'نام   باید  حداکثر  120 کارکتر باشد',
            'first_name.regex' => 'فرمت نام   نامعتبر می باشد',
            'last_name.required' => 'وارد کردن نام  خانوادگی الزامی است',
            'last_name.min' => 'نام خانوادگی باید حداقل  2 کارکتر باشد',
            'last_name.max' => 'نام خانوادگی باید  حداکثر  120 کارکتر باشد',
            'last_name.regex' => 'فرمت نام خانوادگی نامعتبر می باشد',
            'image.required' => 'وارد کردن تصویر الزامی است',
            'image.mimes' => 'فرمت تصویر اشتباه است',
            'activation.required' => 'وارد کردن وضعیت برای دسته الزامی است',
            'activation.numeric' => 'وضعیت نا معتبر است',
            'activation.in' => 'مقدار وضعیت دسته بندی نامعتبر است',
            'email.required' => 'وارد کردن  آدرس ایمیل   الزامی است',
            'email.string' => 'آدرس ایمیل باید حروف  باشد',
            'email.email' => ' فرمت ایمیل اشتباه است',
            'email.unique' => ' آدرس ایمیل نباید تکراری باشد',
            'mobile.required' => 'وارد کردن     شماره تلفن   الزامی است',
            'mobile.digits' => ' شماره تلفن باید  11 رقم باشد',     
            'mobile.unique' => ' شماره تلفن نباید تکراری باشد',
            'password.required' => 'وارد کردن   رمز     الزامی است',
            'password.confirmed' => '     تکرار رمز عبور اشتباه است     ',    
            'password.unique' => ' رمز ورود نباید تکراری باشد',



           
        ];
    }
}
