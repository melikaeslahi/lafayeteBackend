<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'title' => 'required|max:125|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'logo' => 'image|mimes:png,jpg,jpeg,gif',
            'icon' => 'image|mimes:png,jpg,jpeg,gif',
            'keywords' => 'required|max:125|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',

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
            'title.required' => 'وارد کردن  عنوان  تنظیمات   الزامی است',
            'title.min' => ' عنوان تنظیمات   باید حداقل  2 کارکتر باشد',
            'title.max' => '   عنوان تنظیمات باید  حداکثر  125 کارکتر باشد',
            'title.regex' => 'فرمت  عنوان تنظیمات   نامعتبر می باشد',
            'description.required' => 'وارد کردن توضیحات الزامی است',
            'description.min' => 'توضیحات تنظیمات  باید حداقل  2 کارکتر باشد',
            'description.max' => 'توضیحات تنظیمات باید  حداکثر  400 کارکتر باشد',
            'description.regex' => 'فرمت نام تنظیمات نامعتبر می باشد',
            'logo.required' => 'وارد کردن لوگو الزامی است',
            'logo.mimes' => 'فرمت لوگو اشتباه است',
            'icon.required' => 'وارد کردن آیکون الزامی است',
            'icon.mimes' => 'فرمت آیکون اشتباه است',
            'keywords.required' => 'وارد کردن      کلمات کلیدی   الزامی است',
            'keywords.min' => '  کلمات کلیدی     باید حداقل  2 کارکتر باشد',
            'keywords.max' => '      کلمات کلیدی باید  حداکثر  125 کارکتر باشد',
            'keywords.regex' => 'فرمت     کلمات کلیدی   نامعتبر می باشد',
            
        ];
    }
}
