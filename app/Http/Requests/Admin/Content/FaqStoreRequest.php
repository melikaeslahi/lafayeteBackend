<?php

namespace App\Http\Requests\Admin\Content;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class FaqStoreRequest extends FormRequest
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
            'question'=>'required|max:120|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\&?؟ ]+$/u',
            'answer'=>'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
            'status'=>'required|numeric|in:0,1',
            'tag'=>'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            
        ];
       
    }


    public function failedValidation(Validator $validator)  {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'errors'      => $validator->errors()

        ]));

    }
    
    public function messages(){
      return [
        'question.required' => 'وارد کردن سوال الزامی است',
        'question.min' => ' سوال   باید حداقل  5 کارکتر باشد',
        'question.max' => ' سوال  باید  حداکثر  120 کارکتر باشد',
        'question.regex' => 'فرمت سوال   نامعتبر می باشد',
        'answer.required' => 'وارد کردن  پاسخ الزامی است',
        'answer.min' => '   پاسخ باید حداقل  5 کارکتر باشد',
        'answer.max' => '   پاسخ باید  حداکثر  500 کارکتر باشد',
        'answer.regex' => 'فرمت   پاسخ نامعتبر می باشد',
        'status.required' => 'وارد کردن وضعیت برای  سوالات  الزامی است',
        'status.numeric' => 'وضعیت نا معتبر است',
        'status.in' => 'مقدار وضعیت نامعتبر است',
        'tag.required' => 'وارد کردن تگ الزامی است',
        'tag.regex' => 'فرمت تگ اشتباه است',
        ];
    }

}
