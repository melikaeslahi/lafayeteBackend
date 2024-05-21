<?php

namespace App\Http\Requests\Customer\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class StoreTicketRequest extends FormRequest
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
            'subject'=>'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u' , 
            'description'=>'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u' ,  
            'category_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:ticket_categories,id',
            'priority_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:ticket_priorities,id',
            'file' => 'required|mimes:png,jpg,jpeg,gif',
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
            'subject.required' => 'وارد کردن موضوع الزامی است',
            'subject.regex' => 'فرمت  موضوع نامعتبر می باشد',
            'description.required' => 'وارد کردن توضیحات الزامی است',
            'description.regex' => 'فرمت   توضیحات نامعتبر می باشد',
            'category_id.required' => 'وارد کردن  دسته یندی برای تیکت الزامی است',
            'category_id.regex' => 'فرمت نام دسته نامعتبر می باشد',
            'category_id.exists' => 'دسته وارد شده معتبر نمی باشد  ',
            'category_id.min' => ' شناسه دسته بندی باید حداقل 1 باشد',
            'category_id.min' => ' شناسه دسته بندی باید حداکثر 100000000 باشد',
            'priority_id.required' => 'وارد کردن   اولویت   برای تیکت الزامی است',
            'priority_id.regex' => 'فرمت    اولویت  نامعتبر می باشد',
            'priority_id.exists' => 'اولویت وارد شده معتبر نمی باشد  ',
            'priority_id.min' => ' شناسه   اولویت باید حداقل 1 باشد',
            'priority_id.min' => ' شناسه    اولویت  باید حداکثر 100000000 باشد',      
            'file.required' => 'وارد کردن تصویر الزامی است',
            'file.mimes' => 'فرمت تصویر اشتباه است',

        ];
    }
}
