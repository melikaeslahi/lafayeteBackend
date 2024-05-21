<?php

namespace App\Http\Requests\Admin\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TicketCategoryRequest extends FormRequest
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
            'status' => 'required|numeric|in:0,1',
        ];
    }
    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'errors'      => $validator->errors()

        ]));
    }

    public function messages()
    {
        return [
            'name.required' => 'وارد کردن نام دسته الزامی است',
            'name.min' => 'نام دسته باید حداقل  2 کارکتر باشد',
            'name.max' => 'نام دسته باید  حداکثر  120 کارکتر باشد',
            'name.regex' => 'فرمت نام دسته نامعتبر می باشد',
            'status.required' => 'وارد کردن وضعیت برای دسته الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت دسته بندی نامعتبر است',
           
        ];
    }
}
