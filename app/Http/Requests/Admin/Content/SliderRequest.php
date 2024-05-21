<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SliderRequest extends FormRequest
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
                'name' => 'required|min:2|max:120|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'status' => 'required|numeric|in:0,1',
                'parent_id' => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:sliders,id'
            ];
        }else{
            return [
                'name' => 'required|min:2|max:120|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'status' => 'required|numeric|in:0,1',
                'parent_id' => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:sliders,id'
               
    
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
            'name.required' => 'وارد کردن نام   اسلایدر الزامی است',
            'name.min' => 'نام اسلایدر باید حداقل  5 کارکتر باشد',
            'name.max' => 'نام اسلایدر باید  حداکثر  120 کارکتر باشد',
            'name.regex' => 'فرمت نام اسلایدر نامعتبر می باشد',
            
            'status.required' => 'وارد کردن وضعیت برای اسلایدر الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت  اسلایدر نامعتبر است',
            'parent_id.min' => 'نام اسلایدر باید حداقل  5 کارکتر باشد',
            'parent_id.max' => 'نام اسلایدر باید  حداکثر  120 کارکتر باشد',
            'parent_id.regex' => 'فرمت  والد اسلایدر   نامعتبر می باشد',


           
        ];
    }
}
