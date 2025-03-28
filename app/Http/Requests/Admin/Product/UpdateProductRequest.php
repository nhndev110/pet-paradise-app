<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $this->product->id,
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'status' => 'required|boolean',
            'featured' => 'boolean',
            'old_gallery' => 'nullable|array',
            'old_gallery.*' => 'string',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên không được để trống.',
            'name.string' => 'Trường tên phải là chuỗi.',
            'name.max' => 'Trường tên không được vượt quá 255 ký tự.',
            'slug.required' => 'Trường slug không được để trống.',
            'slug.string' => 'Trường slug phải là chuỗi.',
            'slug.max' => 'Trường slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Trường slug phải là duy nhất.',
            'image.image' => 'Trường hình ảnh phải là ảnh.',
            'image.mimes' => 'Trường hình ảnh phải là ảnh có định dạng: jpg, jpeg, png, gif.',
            'image.max' => 'Trường hình ảnh phải có dung lượng không quá 2MB.',
            'description.string' => 'Trường mô tả phải là chuỗi.',
            'price.required' => 'Trường giá không được để trống.',
            'price.numeric' => 'Trường giá phải là số.',
            'price.min' => 'Trường giá phải ít nhất là 0.',
            'quantity.required' => 'Trường số lượng không được để trống.',
            'quantity.integer' => 'Trường số lượng phải là số nguyên.',
            'quantity.min' => 'Trường số lượng phải ít nhất là 0.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',
            'supplier_id.exists' => 'Nhà cung cấp đã chọn không hợp lệ.',
            'status.boolean' => 'Trường trạng thái phải là boolean.',
            'featured.boolean' => 'Trường nổi bật phải là boolean.',
            'old_gallery.array' => 'Trường ảnh cũ phải là mảng.',
            'gallery.array' => 'Trường thư viện ảnh phải là mảng.',
            'gallery.*.image' => 'Trường thư viện ảnh phải là ảnh.',
            'gallery.*.mimes' => 'Trường thư viện ảnh phải là ảnh có định dạng: jpg, jpeg, png, gif.',
            'gallery.*.max' => 'Trường thư viện ảnh phải có dung lượng không quá 2MB.',
        ];
    }
}
