<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeliveryRequest extends FormRequest
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
            'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'amount' => 'required|regex:/^[0-9]+$/u',
            'delivery_time' => 'required|integer',
            'delivery_time_unit' => 'required|regex:/^[ا-یa-zA-Zء-ي., ]+$/u',
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
            'name.required' => 'وارد کردن نام  روش ارسال الزامی است',
            'name.min' => 'نام  روش ارسال باید حداقل  2 کارکتر باشد',
            'name.max' => 'نام  روش ارسال باید  حداکثر  125 کارکتر باشد',
            'name.regex' => 'فرمت نام دسته نامعتبر می باشد',
            'amount.required' => 'وارد کردن  هزینه الزامی است',
            'amount.regex' => 'فرمت    هزینه نامعتبر می باشد',
            'delivery_time.required' => 'وارد کردن  زمان ارسال الزامی است',
            'delivery_time.integer' => ' زمان ازسال باید   عدد صحیح باشد',     
            'delivery_time_unit.required' => 'وارد کردن  واحد زمان ارسال الزامی است',
            'delivery_time_unit.regex' => 'فرمت     واحد زمان ارسال   نامعتبر می باشد',
        ];
    }
}
