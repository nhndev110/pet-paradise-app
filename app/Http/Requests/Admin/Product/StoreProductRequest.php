<?php

namespace App\Http\Requests\Admin\Product;

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
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'featured' => 'nullable|boolean',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'name.max' => 'Tên sản phẩm không được vượt quá 100 ký tự.',
            'slug.required' => 'Vui lòng nhập đường dẫn slug.',
            'slug.string' => 'Slug phải là chuỗi ký tự.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug này đã được sử dụng, vui lòng chọn slug khác.',
            'description.string' => 'Mô tả sản phẩm phải là chuỗi ký tự.',
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric' => 'Giá sản phẩm phải là số.',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'quantity.required' => 'Vui lòng nhập số lượng sản phẩm.',
            'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên.',
            'quantity.min' => 'Số lượng sản phẩm không được nhỏ hơn 0.',
            'status.required' => 'Vui lòng chọn trạng thái sản phẩm.',
            'status.boolean' => 'Trạng thái sản phẩm không hợp lệ.',
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'category_id.exists' => 'Danh mục đã chọn không tồn tại.',
            'image.required' => 'Vui lòng chọn ảnh chính cho sản phẩm.',
            'image.required' => 'Vui lòng chọn ảnh chính cho sản phẩm.',
            'image.image' => 'Tệp phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh không được vượt quá 2048 kilobyte.',
            'gallery.*.image' => 'Các tệp phải là hình ảnh.',
            'gallery.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'gallery.*.max' => 'Ảnh không được vượt quá 2048 kilobyte.',
        ];
    }
}
