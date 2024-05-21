<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class BrandStoreRequest extends FormRequest
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
            'persian_name' => 'required|max:120|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'original_name' => 'required|max:120|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'status' => 'required|numeric|in:0,1',
            'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            
        ];
    }


    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'errors'      => $validator->errors()

        ]));
    }

    public function messages()
    {
        return [
            'persian_name.required' => 'وارد کردن نام فارسی برند  الزامی است',
            'persian_name.min' => 'نام  برند باید حداقل  5 کارکتر باشد',
            'persian_name.max' => 'نام   برند باید  حداکثر  120 کارکتر باشد',
            'persian_name.regex' => 'فرمت نام برند نامعتبر می باشد',
            'original_name.required' => 'وارد کردن نام اصلی برند  الزامی است',
            'original_name.min' => 'نام اصلی برند باید حداقل  5 کارکتر باشد',
            'original_name.max' => 'نام اصلی  برند باید  حداکثر  120 کارکتر باشد',
            'original_name.regex' => 'فرمت نام برند نامعتبر می باشد',       
            'logo.image' => 'تصویر باید از نوع فایل باشد',
            'logo.required' => 'وارد کردن تصویر الزامی است',
            'logo.mimes' => 'فرمت تصویر اشتباه است',
            'status.required' => 'وارد کردن وضعیت برای  برند الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت  برند   نامعتبر است',
            'tags.required' => 'وارد کردن تگ الزامی است',
            'tags.regex' => 'فرمت تگ اشتباه است',
             
        ];
    }
}
