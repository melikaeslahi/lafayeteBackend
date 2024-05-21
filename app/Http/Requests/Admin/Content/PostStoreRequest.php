<?php

namespace App\Http\Requests\Admin\Content;

 
use Illuminate\Foundation\Http\FormRequest;
 

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;
class PostStoreRequest extends FormRequest
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
            'title' => 'required|min:2|max:120|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'body' => 'required|min:5|max:1000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
            'summary' => 'required|min:5|max:300|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
            'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'status' => 'required|numeric|in:0,1',
            'category_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:post_categories,id',
            // 'author_id' => 'min:1|max:100000000|regex:/^[0-9]+$/u|exists:users,id',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'commentable' => 'required|numeric|in:0,1',
            'published_at' => 'numeric'
        ];
    }

    public function failedValidation(Validator $validator)  {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'errors'      => $validator->errors()

        ]));

    }

    public function messages()
    {
        return [
            'title.required' => 'وارد کردن  عنوان پست است',
            'title.min' => '  عنوان پست باید حداقل  2 کارکتر باشد',
            'title.max' => ' عنوان پست باید  حداکثر  120 کارکتر باشد',
            'title.regex' => 'فرمت عنوان پست  نامعتبر می باشد',
            'body.required' => 'وارد کردن  متن پست الزامی است',
            'body.min' => 'متن پست   باید حداقل  5 کارکتر باشد',
            'body.max' => '   متن پست باید  حداکثر  1000 کارکتر باشد',
            'body.regex' => 'فرمت    متن پست نامعتبر می باشد',
            'summary.required' => 'وارد کردن  خلاصه پست الزامی است',
            'summary.min' => '   خلاصه پست باید حداقل  5 کارکتر باشد',
            'summary.max' => '  خلاصه پست باید  حداکثر  300 کارکتر باشد',
            'summary.regex' => 'فرمت   خلاصه پست نامعتبر می باشد',
            'image.required' => 'وارد کردن تصویر الزامی است',
            'image.image'=>'تصویر باید از نوع فایل باشد', 
            'image.mimes' => 'فرمت تصویر اشتباه است',
            'status.required' => 'وارد کردن وضعیت برای دسته الزامی است',
            'status.numeric' => 'وضعیت نا معتبر است',
            'status.in' => 'مقدار وضعیت دسته بندی نامعتبر است',
            'tags.required' => 'وارد کردن تگ الزامی است',
            'tags.regex' => 'فرمت تگ اشتباه است',
            'category_id.min' => '   شماره دسنه بندی پست باید حداقل  1   باشد',
            'category_id.max' => '     شماره دسته بندی پست  حداکثر  100000000 کارکتر باشد',
            'category_id.regex' => 'فرمت  دسته بندی پست  نامعتبر می باشد',
            'commentable.required' => 'وارد کردن وضعیت کامنت برای پست الزامی است',
            'commentable.numeric' => 'وضعیت کامنت نا معتبر است',
            'commentable.in' => 'مقدار وضعیت  کامنت   نامعتبر است',
            'published_at.numeric' => 'تاریخ انتشار  باید عدد باشد'
        ];
    }
}
