<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductCategoryStoreRequest extends FormRequest
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
            'name' => 'required|min:2|max:125|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'description' => 'required|min:2|max:400|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
            'status' => 'required|numeric|in:0,1',
            'show_in_menu' => 'required|numeric|in:0,1',
            'parent_id' => 'nullable|regex:/^[0-9]+$/u|min:1|max:10000000000|exists:product_categories,id',
            'tags' => 'required|min:2|max:400|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg'
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
            'name.required' => 'وارد کردن نام دسته الزامی است',
            'name.min' => 'نام دسته باید حداقل  2 کارکتر باشد',
            'name.max' => 'نام دسته باید  حداکثر  125 کارکتر باشد',
            'name.regex' => 'فرمت نام دسته نامعتبر می باشد',
            'description.required' => 'وارد کردن توضیحات الزامی است',
            'description.min' => 'توضیحات دسته باید حداقل  2 کارکتر باشد',
            'description.max' => 'توضیحات دسته باید  حداکثر  400 کارکتر باشد',
            'description.regex' => 'فرمت نام دسته نامعتبر می باشد',
            'image.required' => 'وارد کردن تصویر الزامی است',
            'image.mimes' => 'فرمت تصویر اشتباه است',
            'status.required' => 'وارد کردن وضعیت برای دسته الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت دسته بندی نامعتبر است',
            'show_in_menu.required' => 'وارد کردن وضعیت نمایش برای دسته الزامی است',
            'show_in_menu.numeric' => 'وضعیت نمایش نا معتبر است',
            'show_in_menu.in' => 'مقدار وضعیت نمایش دسته بندی نامعتبر است',
            'tags.required' => 'وارد کردن تگ الزامی است',
            'tags.regex' => 'فرمت تگ اشتباه است',
            'parent_id.min' => 'نام دسته باید حداقل  1 کارکتر باشد',
            'parent_id.max' => 'نام دسته باید  حداکثر  10000000000 کارکتر باشد',
            'parent_id.regex' => 'فرمت  والد دسته   نامعتبر می باشد',
        ];
    }
}
