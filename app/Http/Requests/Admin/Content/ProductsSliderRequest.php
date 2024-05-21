<?php

namespace App\Http\Requests\Admin\Content;

 
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class ProductsSliderRequest extends FormRequest
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
            'products'=>'required|exists:products,id|array'
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
            'products.required' => 'وارد کردن  محصولات   اسلایدر الزامی است',
            
            'products.exists' => '      محصول انتخاب شده معتبر نمی باشد',
            'products.array' => 'تایپ محصلات باید آرایه باشد',
           


           
        ];
    }
}
