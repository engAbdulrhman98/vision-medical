<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'details_ar' => 'nullable|string',
            'details_en' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
            'in_stock' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name_ar' => 'اسم المنتج بالعربية',
            'name_en' => 'اسم المنتج بالإنجليزية',
            'category_id' => 'القسم الطبي',
            'brand_id' => 'الماركة المصنعة',
            'price' => 'السعر',
            'description_ar' => 'الوصف القصير بالعربية',
            'description_en' => 'الوصف القصير بالإنجليزية',
            'details_ar' => 'المواصفات الفنية بالعربية',
            'details_en' => 'المواصفات الفنية بالإنجليزية',
            'image_file' => 'صورة المنتج',
            'image_url' => 'رابط الصورة',
            'in_stock' => 'حالة المخزون',
        ];
    }
}
