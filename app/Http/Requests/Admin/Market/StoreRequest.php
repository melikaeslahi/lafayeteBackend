<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
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
            'receiver' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'deliverer' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'description' => 'required|min:2|max:400|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
                'marketable_number' => 'required|numeric',
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
                'receiver.required' => 'وارد کردن  دریافت کننده  محصول الزامی است',
                'receiver.min' => 'نام دریافت کننده  باید حداقل  2 کارکتر باشد',
                'receiver.max' => 'نام دریافت کننده باید  حداکثر  120 کارکتر باشد',
                'receiver.regex' => 'فرمت نام دریافت کننده  نامعتبر می باشد',
                'deliverer.required' => 'وارد کردن  تحویل دهنده   محصول الزامی است',
                'deliverer.min' => 'نام   تحویل دهنده   باید حداقل  2 کارکتر باشد',
                'deliverer.max' => 'نام  تحویل دهنده   باید  حداکثر  120 کارکتر باشد',
                'deliverer.regex' => 'فرمت نام تحویل دهنده نامعتبر می باشد',
                'description.required' => 'وارد     توضیحات       الزامی است',
                'description.min' => 'نام    توضیحات     باید حداقل  2 کارکتر باشد',
                'description.max' => 'نام توضیحات باید  حداکثر  120 کارکتر باشد',
                'description.regex' => 'فرمت    توضیحات   نامعتبر می باشد',
                'marketable_number.required' => 'وارد کردن تعداد    محصول  فروخته شده   الزامی است',
                'marketable_number.numeric' => ' مقدار      محصول فروخته شده باید عددی   باشد',
            ];
        }
}
