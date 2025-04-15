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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'status' => 'required|boolean',
            'featured' => 'boolean',
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
            'sku.string' => 'Mã SKU sản phẩm phải là chuỗi ký tự.',
            'sku.max' => 'Mã SKU sản phẩm không được vượt quá 50 ký tự.',
            'sku.unique' => 'Mã SKU này đã được sử dụng, vui lòng chọn mã SKU khác.',
            'stock.required' => 'Vui lòng nhập số lượng sản phẩm.',
            'stock.integer' => 'Số lượng sản phẩm phải là số nguyên.',
            'stock.min' => 'Số lượng sản phẩm không được nhỏ hơn 0.',
            'status.required' => 'Vui lòng chọn trạng thái sản phẩm.',
            'status.boolean' => 'Trạng thái sản phẩm không hợp lệ.',
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'category_id.exists' => 'Danh mục đã chọn không tồn tại.',
            'supplier_id.exists' => 'Nhà cung cấp đã chọn không tồn tại.',
            'thumbnail.required' => 'Vui lòng chọn ảnh chính cho sản phẩm.',
            'thumbnail.required' => 'Vui lòng chọn ảnh chính cho sản phẩm.',
            'thumbnail.image' => 'Tệp phải là hình ảnh.',
            'thumbnail.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'thumbnail.max' => 'Ảnh không được vượt quá 2048 kilobyte.',
            'gallery.*.image' => 'Các tệp phải là hình ảnh.',
            'gallery.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'gallery.*.max' => 'Ảnh không được vượt quá 2048 kilobyte.',
        ];
    }
}
