<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class MenuUpdateRequest extends FormRequest
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
            'name' => 'required|max:120|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'url' => 'required|max:120|min:2',
            'status' => 'required|numeric|in:0,1',
            'parent_id' => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:post_categories,id'
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
            'name.required' => 'وارد کردن نام  منو الزامی است',
            'name.min' => 'نام منو باید حداقل  5 کارکتر باشد',
            'name.max' => 'نام منو باید  حداکثر  120 کارکتر باشد',
            'name.regex' => 'فرمت نام منو نامعتبر می باشد',
            'url.required' => 'وارد کردن  آدرس  منو است',
            'url.min' => '   آدرس  منو باید حداقل  2 کارکتر باشد',
            'url.max' => '  آدرس منو باید  حداکثر  120 کارکتر باشد',
            'status.required' => 'وارد کردن وضعیت برای منو الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت  منو نامعتبر است',
            'parent_id.min' => 'نام منو باید حداقل  5 کارکتر باشد',
            'parent_id.max' => 'نام منو باید  حداکثر  120 کارکتر باشد',
            'parent_id.regex' => 'فرمت  والد منو   نامعتبر می باشد',
        ];
    }
}
