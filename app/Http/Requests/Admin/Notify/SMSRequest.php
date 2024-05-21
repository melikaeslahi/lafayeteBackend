<?php

namespace App\Http\Requests\Admin\Notify;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SMSRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  true;
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
            'body' =>'required|max:400|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\&?؟ ]+$/u',
            'status' => 'required|numeric|in:0,1',
            'published_at' => 'required|numeric' 
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
            'title.required' => 'وارد کردن      عنوان   الزامی است',
            'title.min' => '       عنوان باید حداقل  2 کارکتر باشد',
            'title.max' => ' عنوان   باید  حداکثر  125 کارکتر باشد',
            'title.regex' => 'فرمت   عنوان  نامعتبر می باشد',
            'body.required' => 'وارد کردن توضیحات الزامی است',
            'body.min' => 'توضیحات   باید حداقل  2 کارکتر باشد',
            'body.max' => 'توضیحات دسته باید  حداکثر  400 کارکتر باشد',
            'body.regex' => 'فرمت  توضیحات   نامعتبر می باشد',
            'published_at.required' => 'وارد کردن   تاریخ انتشار     الزامی است',
            'published_at.numeric' => 'تاریخ انتشار  باید عدد باشد',
            'status.required' => 'وارد کردن وضعیت برای   پیام الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت   پیام   نامعتبر است',
        ];
    }
}
