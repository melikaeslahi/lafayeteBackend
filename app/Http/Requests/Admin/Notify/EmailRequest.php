<?php

namespace App\Http\Requests\Admin\Notify;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmailRequest extends FormRequest
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
            'body' =>'required|max:400|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\&?؟ ]+$/u',
            'subject' => 'required|max:125|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
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
            'subject.required' => 'وارد کردن  موضوع ایمیل   الزامی است',
            'subject.min' => '   موضوع ایمیل باید حداقل  2 کارکتر باشد',
            'subject.max' => ' موضوع   باید  حداکثر  125 کارکتر باشد',
            'subject.regex' => 'فرمت   موضوع  نامعتبر می باشد',
            'body.required' => 'وارد کردن توضیحات الزامی است',
            'body.min' => 'توضیحات   باید حداقل  2 کارکتر باشد',
            'body.max' => 'توضیحات دسته باید  حداکثر  400 کارکتر باشد',
            'body.regex' => 'فرمت  توضیحات   نامعتبر می باشد',
            'published_at.required' => 'وارد کردن   تاریخ انتشار ایمیل   الزامی است',
            'published_at.numeric' => 'تاریخ انتشار  باید عدد باشد',
            'status.required' => 'وارد کردن وضعیت برای  ایمیل الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت    ایمیل نامعتبر است',
            
        ];
    }
}
