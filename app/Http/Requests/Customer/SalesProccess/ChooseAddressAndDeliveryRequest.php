<?php

namespace App\Http\Requests\Customer\SalesProccess;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class ChooseAddressAndDeliveryRequest extends FormRequest
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
            'address_id'=>'required|exists:addresses,id',
            'delivery_id'=>'required|exists:delivery,id',
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
            'address_id.required' => ' وارد کردن  آدرس الزامی است ',
            'address_id.exists' => ' آدرسی با این  نشانی یافت نشد',
            'delivery_id.required' => ' وارد کردن  شیوه ی ارسال الزامی است ',
            'delivery_id.exists' => ' روش ارسالی   با این  شیوه یافت نشد ',
            
        ];
    }
}
