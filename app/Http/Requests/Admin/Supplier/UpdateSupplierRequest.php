<?php

namespace App\Http\Requests\Admin\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'phone' => 'required|string|max:20|unique:suppliers,phone,' . $this->supplier->id,
            'email' => 'required|email|unique:suppliers,email,' . $this->supplier->id,
            'address' => 'required|string|max:255'
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
            'name.string' => 'Tên phải là chuỗi',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.string' => 'Số điện thoại phải là chuỗi',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',
            'phone.unique' => 'Số điện thoại phải là duy nhất',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email phải là địa chỉ email hợp lệ',
            'email.unique' => 'Email phải là duy nhất',
            'address.required' => 'Địa chỉ là bắt buộc',
            'address.string' => 'Địa chỉ phải là chuỗi',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự'
        ];
    }
}
