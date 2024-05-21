<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PropertyValueStoreRequest extends FormRequest
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
            'value' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'product_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:products,id',
            'type' => 'required|numeric|in:0,1',
            'price_increase'=>'nullable|numeric'
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
            'value.required' => 'وارد کردن  مقدار   الزامی است',
            'value.min' => '   مقدار باید حداقل  5 کارکتر باشد',
            'value.max' => '   مقدار باید  حداکثر  120 کارکتر باشد',
            'value.regex' => 'فرمت  مقدار   نامعتبر می باشد',
            'price_increase.numeric' => 'فرمت  افزایش قیمت  باید از نوع عددی باشد است',     
            'type.required' => 'وارد کردن تایپ  برای الزامی است',
            'type.numeric' => 'وضعیت نا معتبر است',
            'type.in' => ' تایپ فرم   نامعتبر است',
            'product_id.required' => 'وارد کردن  مقدار   الزامی است',         
            'product_id.min' => 'نام    محصول باید حداقل   1 کارکتر باشد',
            'product_id.max' => 'نام     محصول باید  حداکثر  120 کارکتر باشد',
            'product_id.regex' => 'فرمت    نام محصول   نامعتبر می باشد',
            

        ];
    }
}
