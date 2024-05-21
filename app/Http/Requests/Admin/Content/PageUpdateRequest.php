<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class PageUpdateRequest extends FormRequest
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
            'title' => 'required|max:120|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'body' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
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
            'title.required' => 'وارد کردن  عنوان  صفحه الزامی است',
            'title.min' => 'نام  صفحه باید حداقل  5 کارکتر باشد',
            'title.max' => 'نام  صفحه باید  حداکثر  120 کارکتر باشد',
            'title.regex' => 'فرمت  عنوان صفحه نامعتبر می باشد',
            'body.required' => 'وارد کردن بدنه صفحه الزامی است',
            'body.min' => 'بدنه صفحه باید حداقل  5 کارکتر باشد',
            'body.max' => ' بدنه صفحه باید  حداکثر  500 کارکتر باشد',
            'body.regex' => 'فرمت بدنه صفحه نامعتبر می باشد',  
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت صفحه نامعتبر است',
            'tags.required' => 'وارد کردن تگ الزامی است',
            'tags.regex' => 'فرمت تگ اشتباه است',
            
        ];
    }
}
