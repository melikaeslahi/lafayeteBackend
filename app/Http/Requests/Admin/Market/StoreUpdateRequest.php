<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUpdateRequest extends FormRequest
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
            'marketable_number' => 'required|numeric',
            'frozen_number' => 'required|numeric',
            'sold_number' => 'required|numeric',
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
            'marketable_number.required' => 'وارد کردن تعداد قابل فروش   محصول الزامی است',
            'marketable_number.numeric' => ' مقدار قابل فروش  محصول باید عددی   باشد',
            'frozen_number.required' => 'وارد کردن تعداد  رزرو   محصول الزامی است',
            'frozen_number.numeric' => ' مقدار    رزرو   محصول باید عددی   باشد',
            'marketable_number.required' => 'وارد کردن تعداد    محصول  فروخته شده   الزامی است',
            'marketable_number.numeric' => ' مقدار      محصول فروخته شده باید عددی   باشد',


        ];
    }
}
