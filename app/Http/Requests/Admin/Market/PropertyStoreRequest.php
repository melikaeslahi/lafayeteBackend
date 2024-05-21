<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PropertyStoreRequest extends FormRequest
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
            'name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'unit' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'category_id' => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:product_categories,id',
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
            'name.required' => 'وارد کردن نام  فرم الزامی است',
            'name.min' => 'نام  فرم باید حداقل  1  کارکتر باشد',
            'name.max' => 'نام فرم باید  حداکثر  120 کارکتر باشد',
            'name.regex' => 'فرمت نام فرم نامعتبر می باشد',
            'unit.required' => 'وارد کردن  واحد  فرم الزامی است',
            'unit.min' => 'واحد  فرم باید حداقل  1  کارکتر باشد',
            'unit.max' => 'واحد فرم باید  حداکثر  120 کارکتر باشد',
            'unit.regex' => 'فرمت واحد فرم نامعتبر می باشد',
            'category_id.min' => 'نام دسته بندی محصول باید حداقل  5 کارکتر باشد',
            'category_id.max' => 'نام دسته بندی محصول باید  حداکثر  120 کارکتر باشد',
            'category_id.regex' => 'فرمت  والد محصول   نامعتبر می باشد',
           

        ];
    }
}
