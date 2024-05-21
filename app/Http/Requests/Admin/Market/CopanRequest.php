<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CopanRequest extends FormRequest
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
            'code' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'amount_type' => 'required|numeric|in:0,1',
            'amount'=>[request()->amount_type == 0 ? 'max:100' :'' , 'numeric' , 'required'],
            'discount_ceiling' => 'required|max:10000000|min:1|numeric',
            'type' => 'required|numeric|in:0,1',
            'user_id' => 'required_if:type,==,1|min:1|max:100000000|regex:/^[0-9]+$/u|exists:users,id',
            'status' => 'required|numeric|in:0,1',
            'start_date' => 'required|numeric',
            'end_date' => 'required|numeric'
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
            'code.required' => 'وارد  کد تخفیف الزامی است',  
            'code.regex' => 'فرمت   کد تخفیف  نامعتبر می باشد',
            'amount_type.required' => 'وارد کردن  نوع تخفیف الزامی است',
            'amount_type.numeric' => ' نوع تخفیف باید از نوع عددی باشد',
            'amount_type.in' => 'مقدار وارد شده برای نوع تخفیف نامعتبر است',
            'amount.required' => 'وارد کردن  میزان   تخفیف  الزامی است',
            'amount.numeric' => ' میزان تخفیف باید از نوع عددی باشد',
            'amount.in' => 'مقدار   وارد شده برای میزان تخفیف نامعتبر است',
            'amount.max' => '        میزان تخفیف درصدی حداکثر 100 است       ',
            'discount_ceiling.required' => ' وارد کردن حداکثر تخفیف الزامی است',
            'discount_ceiling.min' => 'توضیحات دسته باید حداقل  1 کارکتر باشد',
            'discount_ceiling.max' => '   حداکثر تخفیف باید  حداکثر  10000000   باشد',
            'discount_ceiling.numeric' => ' مقدار وارد شده برای حداکثر تخفیف باید از نوع عددی باشد',
            'type.required' => 'وارد کردن تایپ تخفیف است',
            'type.numeric' => ' مقدار وارد شده برای  تایپ نامعتبر می باشد',
            'type.in' => 'مقدار  تاپپ نامعتبر است',
            'user_id.min' => 'نام کاربر باید حداقل  1 کارکتر باشد',
            'user_id.max' => 'نام کاربر باید  حداکثر  10000000 کارکتر باشد',
            'user_id.regex' => 'فرمت     وارد شده برا ینام کاربر    نامعتبر می باشد',
            'status.required' => 'وارد کردن وضعیت برای تخفیف   الزامی است',
            'status.numeric' => 'وضعیت   تخفیف باید از نوع عددی باشد    ',
            'status.in' => 'مقدار وضعیت    تخفیف نامعتبر است',
            'start_date.required' => 'وارد کردن     تاریخ شروع   الزامی است',
            'end_date.required' => 'وارد کردن     تاریخ پایان   الزامی است',
            'start_date.numeric' => '   تاریخ شروع  باید عدد باشد',
            'end_date.numeric' => '   تاریخ  پایان  باید عدد باشد',

           
        ];
    }
}
