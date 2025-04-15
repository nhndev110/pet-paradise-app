<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $this->category->id,
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
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
            'name.required' => 'Tên là bắt buộc',
            'name.string' => 'Tên phải là một chuỗi',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'name.unique' => 'Tên phải là duy nhất',
            'slug.required' => 'Slug là bắt buộc',
            'slug.string' => 'Slug phải là một chuỗi',
            'slug.max' => 'Slug không được vượt quá 255 ký tự',
            'thumbnail.image' => 'Hình ảnh không hợp lệ',
            'thumbnail.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif',
            'thumbnail.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            'description.string' => 'Mô tả phải là một chuỗi',
            'parent_id.exists' => 'Danh mục cha không tồn tại',
        ];
    }
}
