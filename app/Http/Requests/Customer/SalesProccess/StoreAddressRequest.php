<?php

namespace App\Http\Requests\Customer\SalesProccess;

use App\Rules\PostalCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreAddressRequest extends FormRequest
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
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required',
            'postal_code' =>  ['required', new PostalCode()],
            'no' => 'required',
            'unit' => 'required',
            'receiver' => 'sometimes',
            'recipient_first_name' => 'required_with:receiver,on',
            'recipient_last_name' => 'required_with:receiver,on',
            'mobile' => 'required_with:receiver,on',
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
            'province_id.required' => ' وارد کردن استان الزامی است   ',
            'province_id.exists' => 'استانی با این نام یافت نشد',
            'city_id.required' => ' وارد کردن شهر الزامی است   ',
            'city_id.exists' => ' شهری با این نام یافت نشد',
            'address.required' => ' وارد کردن  نشانی الزامی است   ',
            'postal_code.required' => ' وارد کردن   کد پستی الزامی است   ',
            'no.required' => ' وارد کردن   پلاک الزامی است   ',
            'unit.required' => ' وارد کردن   واحد الزامی است   ',
            'recipient_first_name.required_with'=> 'وارد کردن نام دریافت کننده محصول الزامی است',
            'recipient_last_name.required_with'=> 'وارد کردن  نام خانوادگی دریافت کننده محصول الزامی است',
            'mobile.required_with'=> 'وارد کردن  شماره تلفن دریافت کننده محصول الزامی است',
        ];
    }


}
