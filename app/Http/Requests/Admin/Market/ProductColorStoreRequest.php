<?php

namespace App\Http\Requests\Admin\Market;

 
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class ProductColorStoreRequest extends FormRequest
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
            'color_name'=>'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u' ,
            'color'=>'required|max:120|min:2' ,
            'price_increase'=>'numeric'
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
            'color_name.required' => 'وارد کردن  نام رنگ الزامی است',
            'color_name.min' => 'نام  رنگ باید حداقل  2 کارکتر باشد',
            'color_name.max' => 'نام رنگ باید  حداکثر  120 کارکتر باشد',
            'color_name.regex' => 'فرمت نام دسته نامعتبر می باشد',
            'color.required' => 'وارد کردن کد رنگ الزامی است',
            'color.min' => 'نام   کد رنگ باید حداقل  2 کارکتر باشد',
            'color.max' => 'نام  کد رنگ باید  حداکثر  120 کارکتر باشد', 
            'price_increase.numeric' => 'فرمت  افزایش قیمت  باید از نوع عددی باشد است',
    
        ];
    }
}
