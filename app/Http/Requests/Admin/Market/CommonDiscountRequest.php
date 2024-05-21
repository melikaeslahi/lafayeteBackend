<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommonDiscountRequest extends FormRequest
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
            'title' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'percentage' => 'required|max:100|min:1|numeric',
            'discount_ceiling' => 'required|max:10000000|min:1|numeric',
            'minimal_order_amount' => 'required|max:100000000|min:1|numeric',
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
            'title.required' => 'وارد کردن عنوان تخفیف است',
            'title.regex' => 'فرمت   تخفیف  نامعتبر می باشد',
            'percentage.required' => 'وارد کردن  درصد تخفیف   الزامی است',
            'percentage.min' => '   درصد تخفیف باید حداقل 1   باشد',
            'percentage.max' => '   درصد تخفیف باید  حداکثر  100    باشد',
            'percentage.numeric' => '     درصد تخفیف   باید از نوع عددی باشد  ',
            'minimal_order_amount.required' => 'وارد کردن  حداکثر مبلغ سفارش کاربر        الزامی است',
            'minimal_order_amount.min' => ' حداکثر مبلغ سفارش کاربر باید حداقل 1   باشد',
            'minimal_order_amount.max' => ' حداکثر مبلغ سفارش کاربر باید  حداکثر  100000000    باشد',
            'minimal_order_amount.numeric' => ' حداکثر  مبلغ سفارش کاربر   باید از نوع عددی باشد  ',
            'discount_ceiling.required' => ' وارد کردن حداکثر تخفیف الزامی است',
            'discount_ceiling.min' => 'توضیحات دسته باید حداقل  1 کارکتر باشد',
            'discount_ceiling.max' => '   حداکثر تخفیف باید  حداکثر  10000000   باشد',
            'discount_ceiling.numeric' => ' مقدار وارد شده برای حداکثر تخفیف باید از نوع عددی باشد',
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
