<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AmazingSaleRequest extends FormRequest
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
            'product_id'=>'nullable|min:1|max:10000000000|regex:/^[0-9]+$/u|exists:products,id',
            'percentage' => 'required|max:100|min:1|numeric', 
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
            'percentage.required' => 'وارد کردن  درصد تخفیف   الزامی است',
            'percentage.min' => '   درصد تخفیف باید حداقل 1   باشد',
            'percentage.max' => '   درصد تخفیف باید  حداکثر  100    باشد',
            'percentage.numeric' => '     درصد تخفیف   باید از نوع عددی باشد  ',
            'status.required' => 'وارد کردن وضعیت برای  فروش فوقالعاده الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت   فروش فوقالعاده    نامعتبر است',
            'start_date.required' => 'وارد کردن     تاریخ شروع   الزامی است',
            'end_date.required' => 'وارد کردن     تاریخ پایان   الزامی است',
            'start_date.numeric' => '   تاریخ شروع  باید عدد باشد',
            'end_date.numeric' => '   تاریخ  پایان  باید عدد باشد',
            'product_id.min' => 'نام محصول  باید حداقل  1 کارکتر باشد',
            'product_id.max' => 'نام   محصول باید  حداکثر  10000000000 کارکتر باشد',
            'product_id.regex' => 'فرمت   نام محصول نامعتبر می باشد',
        ];
    }
}
