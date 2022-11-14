<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'image',
            'images.*' => 'nullable|mimes:jpg,jpeg,png,gif|max:30000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'إسم المنتج مطلوب',
            'name.string' => 'الإسم يجب ان يكون نصآ',
            'name.max' => 'الإسم لا يجب أن يتجاوز 255 حرف',
            'name.min' => 'يجب كتابة 4 حروف على الأقل',
            'category_id.required' => 'الصنف مطلوب',
            'category_id.exists' => 'الصنف غير موجود',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب ان يكون قيمة رقمية او عشرية',
            'price.min' => 'أقل قيمة للسعر هي 0',
            'image.image' => 'الرجاء إرفاق صورة غلاف',
            'images.*.mimes' => 'إمتداد الصورة يجب ان يكون : jpg,jpeg,png,gif',
        ];
    }
}
