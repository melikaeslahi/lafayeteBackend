<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
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
                'introduction' => 'required|max:8000|min:5',
                'weight' => 'nullable|max:1000|min:1|numeric',
                'length' => 'nullable|max:1000|min:1|numeric',
                'width' => 'nullable|max:1000|min:1|numeric',
                'height' => 'nullable|max:1000|min:1|numeric',
                'price' => 'required|regex:/^[0-9.]+$/u',
                'image' => 'image|mimes:png,jpg,jpeg,gif',
                'status' => 'required|numeric|in:0,1',
                'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'marketable' => 'required|numeric|in:0,1',
                'category_id' => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:product_categories,id',
                'brand_id' => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:brands,id',
                'published_at' => 'required|numeric',
                
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
                'name.required' => 'وارد کردن نام محصول الزامی است',
                'name.min' => 'نام محصول باید حداقل  5 کارکتر باشد',
                'name.max' => 'نام محصول باید  حداکثر  120 کارکتر باشد',
                'name.regex' => 'فرمت نام محصول نامعتبر می باشد',
                'introduction.required' => 'وارد کردن توضیحات الزامی است',
                'introduction.min' => 'توضیحات محصول باید حداقل  5 کارکتر باشد',
                'introduction.max' => 'توضیحات محصول باید  حداکثر  500 کارکتر باشد',        
                'weight.min' => 'وزن محصول باید حداقل  5 کارکتر باشد',
                'weight.max' => 'وزن محصول باید  حداکثر  120 کارکتر باشد',
                'weight.numeric' => 'وزن محصول باید  حداکثر  120 کارکتر باشد',
                'length.required' => 'وارد کردن طول محصول الزامی است',
                'length.min' => 'طول محصول باید حداقل  5 کارکتر باشد',
                'length.max' => 'طول محصول باید  حداکثر  120 کارکتر باشد',
                'length.numeric' => 'طول محصول باید از نوع عددی باشد',
                'width.required' => 'وارد کردن عرض محصول الزامی است',
                'width.min' => 'عرض محصول باید حداقل  5 کارکتر باشد',
                'width.max' => 'عرض محصول باید  حداکثر  120 کارکتر باشد',
                'width.numeric' => 'عرض محصول باید از نوع عددی  باشد',
                'height.required' => 'وارد کردن ارتفاع محصول الزامی است',
                'height.min' => 'ارتفاع محصول باید حداقل  5 کارکتر باشد',
                'height.max' => 'ارتفاع محصول باید  حداکثر  120 کارکتر باشد',
                'height.numeric' => 'ارتفاع محصول باید  از نوع عددی باشد',
                'price.required' => 'وارد کردن قیمت محصول الزامی است',
                'price.regex' => 'فرمت قیمت محصول صحیح نمی باشد',
                'image.image'=>'تصویر باید از نوع فایل باشد', 
                'image.mimes' => 'فرمت تصویر اشتباه است',
                'status.required' => 'وارد کردن وضعیت برای محصول الزامی است',
                'status.numeric' => 'وضعیت نا معتبر است',
                'status.in' => 'مقدار وضعیت محصول بندی نامعتبر است',
                'marketable.required' => 'وارد کردن وضعیت فروش برای محصول الزامی است',
                'marketable.numeric' => 'وضعیت فروش نا معتبر است',
                'marketable.in' => 'مقدار وضعیت فروش محصول نامعتبر است',
                'tags.required' => 'وارد کردن تگ الزامی است',
                'tags.regex' => 'فرمت تگ اشتباه است',
                'category_id.min' => 'نام دسته بندی محصول باید حداقل  5 کارکتر باشد',
                'category_id.max' => 'نام دسته بندی محصول باید  حداکثر  120 کارکتر باشد',
                'category_id.regex' => 'فرمت  والد محصول   نامعتبر می باشد',
                'brand_id.min' => 'نام برند محصول باید حداقل  5 کارکتر باشد',
                'brand_id.max' => 'نام برند محصول باید  حداکثر  120 کارکتر باشد',
                'brand_id.regex' => 'فرمت  والد محصول   نامعتبر می باشد',
                'published_at.numeric' => 'تاریخ انتشار  باید عدد باشد',
                'meta_key.required' => 'وارد کردن  ویژگی محصول الزامی است',
                'meta_value.required' => 'وارد کردن  مقدار ویژگی محصول الزامی است',
    
            ];
        }
 
}
