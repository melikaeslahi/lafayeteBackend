<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BannerUpdateRequest extends FormRequest
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
            'title'=>'required|min:2|max:120|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'url'=>'required|max:120|min:2',
            'position'=>'required|numeric',
            'status'=>'required|numeric|in:0,1',
            'image'=>'image|mimes:jpg,png,jpeg,gif,svg'
        ];
    }
    public function failedValidation(Validator $validator)
    {

        throw new  HttpResponseException(response()->json(
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
            'title.required' => 'وارد کردن  عنوان بنر است',
            'title.min' => '  عنوان بنر باید حداقل  2 کارکتر باشد',
            'title.max' => ' عنوان بنر باید  حداکثر  120 کارکتر باشد',
            'title.regex' => 'فرمت   بنر  نامعتبر می باشد',
            'image.image'=>'تصویر باید از نوع فایل باشد', 
            'image.mimes' => 'فرمت تصویر اشتباه است',
            'status.required' => 'وارد کردن وضعیت برای  بنر الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت بنر نامعتبر است',
            'position.required' => 'وارد کردن  موقعیت برای  بنر الزامی است',
            'position.numeric' => ' موقعیت بنر نا معتبر است',
            'url.required' => 'وارد کردن  آدرس  بنر است',
            'url.min' => '   آدرس بنر باید حداقل  2 کارکتر باشد',
            'url.max' => '  آدرس بنر باید  حداکثر  120 کارکتر باشد',
        ];
    }
}
