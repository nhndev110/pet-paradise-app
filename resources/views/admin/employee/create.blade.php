@extends('admin.layouts.app')

@section('title', 'Thêm mới nhân viên')

@section('content')
    <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.employees.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Thêm mới nhân viên</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <button type="submit" name="save-continue" class="btn btn-primary rounded-pill mr-1">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu và sửa tiếp</span>
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu lại</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin nhân viên</h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-admin.input-label name="name" required>Họ và
                                                        tên</x-admin.input-label>
                                                    <x-admin.input-text name="name" placeholder="Nhập họ và tên" />
                                                    <x-admin.input-error name="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-admin.input-label name="email" required>Email</x-admin.input-label>
                                                    <x-admin.input-text type="email" name="email"
                                                        placeholder="Nhập email" />
                                                    <x-admin.input-error name="email" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-admin.input-label name="phone_number" required>Số điện
                                                        thoại</x-admin.input-label>
                                                    <x-admin.input-text name="phone_number"
                                                        placeholder="Nhập số điện thoại" />
                                                    <x-admin.input-error name="phone_number" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-admin.input-label name="birth_date">Ngày sinh</x-admin.input-label>
                                                    <x-admin.input-date name="birth_date" />
                                                    <x-admin.input-error name="birth_date" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-admin.input-label name="position_id" required>Chức
                                                        vụ</x-admin.input-label>
                                                    <x-admin.input-select class="select2" name="position_id" required>
                                                        <option value="">-- Chọn chức vụ --</option>
                                                        @foreach ($positions as $position)
                                                            <option value="{{ $position->id }}"
                                                                {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                                                {{ $position->name }}
                                                            </option>
                                                        @endforeach
                                                    </x-admin.input-select>
                                                    <x-admin.input-error name="position_id" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-admin.input-label name="is_male" required>Giới
                                                        tính</x-admin.input-label>
                                                    <div class="d-flex mt-2">
                                                        <div class="custom-control custom-radio mr-3">
                                                            <input class="custom-control-input" type="radio"
                                                                id="is_male_1" name="is_male" value="1"
                                                                {{ old('is_male', 1) ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="is_male_1">Nam</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio"
                                                                id="is_male_0" name="is_male" value="0"
                                                                {{ old('is_male') === '0' ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="is_male_0">Nữ</label>
                                                        </div>
                                                    </div>
                                                    <x-admin.input-error name="is_male" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-admin.input-label name="password" required>Mật
                                                        khẩu</x-admin.input-label>
                                                    <x-admin.input-text type="password" name="password"
                                                        placeholder="Nhập mật khẩu" />
                                                    <x-admin.input-error name="password" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-admin.input-label name="password_confirmation" required>Xác nhận mật
                                                        khẩu</x-admin.input-label>
                                                    <x-admin.input-text type="password" name="password_confirmation"
                                                        placeholder="Xác nhận mật khẩu" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <x-admin.input-label name="address" required>Địa chỉ</x-admin.input-label>
                                            <x-admin.input-text name="address" placeholder="Nhập địa chỉ" />
                                            <x-admin.input-error name="address" />
                                        </div>

                                        <div class="form-group">
                                            <x-admin.input-label name="bio">Giới thiệu</x-admin.input-label>
                                            <x-admin.input-textarea name="bio" rows="3" class="editor"
                                                placeholder="Nhập thông tin giới thiệu"></x-admin.input-textarea>
                                            <x-admin.input-error name="bio" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-admin.input-label name="avatar">Ảnh đại diện</x-admin.input-label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file"
                                                        class="custom-file-input @error('avatar') is-invalid @enderror"
                                                        id="avatar" name="avatar" accept="image/*">
                                                    <label class="custom-file-label" for="avatar">Chọn ảnh</label>
                                                </div>
                                            </div>
                                            <x-admin.input-error name="avatar" />
                                            <div class="mt-2" id="avatar-preview-container" style="display: none;">
                                                <img id="avatar-preview" src="#" alt="Preview"
                                                    class="img-thumbnail" style="max-height: 200px;">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <x-admin.input-label name="role" required>Vai trò</x-admin.input-label>
                                            <select class="form-control @error('role') is-invalid @enderror custom-select"
                                                id="role" name="role">
                                                <option value="">-- Chọn vai trò --</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                    Admin
                                                </option>
                                                <option value="employee"
                                                    {{ old('role', 'employee') == 'employee' ? 'selected' : '' }}>
                                                    Nhân viên
                                                </option>
                                            </select>
                                            <x-admin.input-error name="role" />
                                        </div>

                                        <div class="form-group">
                                            <x-admin.input-label name="is_locked">Trạng thái</x-admin.input-label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    class="custom-control-input @error('is_locked') is-invalid @enderror"
                                                    id="is_locked" name="is_locked" value="1"
                                                    {{ old('is_locked') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_locked">Đã khóa</label>
                                            </div>
                                            <x-admin.input-error name="is_locked" />
                                        </div>

                                        <div class="form-group">
                                            <x-admin.input-label name="hire_date">Ngày vào làm</x-admin.input-label>
                                            <x-admin.input-date name="hire_date" />
                                            <x-admin.input-error name="hire_date" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function() {
            $('#avatar').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#avatar-preview').attr('src', e.target.result);
                        $('#avatar-preview-container').show();
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('.editor').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endpush
