<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'role' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hire_date' => 'required|date',
            'is_male' => 'required|boolean',
            'birth_date' => 'nullable|date',
            'address' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'is_locked' => 'boolean',
            'position_id' => 'required|exists:positions,id',
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
            'name.required' => 'Tên nhân viên là bắt buộc.',
            'name.string' => 'Tên nhân viên không hợp lệ.',
            'name.max' => 'Tên nhân viên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email đã tồn tại.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.string' => 'Số điện thoại không hợp lệ.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'role.string' => 'Vai trò không hợp lệ.',
            'avatar.image' => 'Ảnh đại diện không hợp lệ.',
            'avatar.mimes' => 'Ảnh đại diện phải là định dạng jpeg, png, jpg, gif hoặc svg.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'hire_date.required' => 'Ngày tuyển dụng là bắt buộc.',
            'hire_date.date' => 'Ngày tuyển dụng không hợp lệ.',
            'is_male.boolean' => 'Giới tính không hợp lệ.',
            'birth_date.date' => 'Ngày sinh không hợp lệ.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ không hợp lệ.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'bio.string' => 'Tiểu sử không hợp lệ.',
            'bio.max' => 'Tiểu sử không được vượt quá 1000 ký tự.',
            'position_id.required' => 'Chức vụ là bắt buộc.',
            'position_id.exists' => 'Chức vụ không tồn tại.',
        ];
    }
}
