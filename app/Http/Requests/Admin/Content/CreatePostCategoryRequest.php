<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreatePostCategoryRequest extends FormRequest
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
            'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'status' => 'required|numeric|in:0,1',
            'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
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
            'name.required' => 'وارد کردن نام دسته الزامی است',
            'name.min' => 'نام دسته باید حداقل  5 کارکتر باشد',
            'name.max' => 'نام دسته باید  حداکثر  120 کارکتر باشد',
            'name.regex' => 'فرمت نام دسته نامعتبر می باشد',
            'description.required' => 'وارد کردن توضیحات الزامی است',
            'description.min' => 'توضیحات دسته باید حداقل  5 کارکتر باشد',
            'description.max' => 'توضیحات دسته باید  حداکثر  500 کارکتر باشد',
            'description.regex' => 'فرمت نام دسته نامعتبر می باشد',
            'image.image' => 'تصویر باید از نوع فایل باشد',
            'image.required' => 'وارد کردن تصویر الزامی است',
            'image.mimes' => 'فرمت تصویر اشتباه است',
            'status.required' => 'وارد کردن وضعیت برای دسته الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت دسته بندی نامعتبر است',
            'tags.required' => 'وارد کردن تگ الزامی است',
            'tags.regex' => 'فرمت تگ اشتباه است',
            'parent_id.min' => 'نام دسته باید حداقل  5 کارکتر باشد',
            'parent_id.max' => 'نام دسته باید  حداکثر  120 کارکتر باشد',
            'parent_id.regex' => 'فرمت  والد دسته   نامعتبر می باشد',
        ];
    }
}
