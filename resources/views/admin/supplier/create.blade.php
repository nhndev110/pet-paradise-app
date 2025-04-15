@extends('admin.layouts.app')

@section('title', 'Tạo nhà cung cấp mới')

@section('content')
    <form action="{{ route('admin.suppliers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.suppliers.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Tạo nhà cung cấp mới</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <button type="submit" class="btn btn-primary rounded-pill mr-1">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu lại</span>
                            </button>
                            <button type="submit" name="save-continue" class="btn btn-primary rounded-pill">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu và sửa tiếp</span>
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
                        <x-admin.alert-message />

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin nhà cung cấp</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <x-admin.input-label name="name" required>Tên nhà cung cấp</x-admin.input-label>
                                    <x-admin.input-text name="name" placeholder="Nhập tên nhà cung cấp" />
                                    <x-admin.input-error name="name" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="email" required>Email</x-admin.input-label>
                                    <x-admin.input-text type="email" name="email" placeholder="Nhập email" />
                                    <x-admin.input-error name="email" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="phone" required>Số điện thoại</x-admin.input-label>
                                    <x-admin.input-text name="phone" placeholder="Nhập số điện thoại" />
                                    <x-admin.input-error name="phone" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="address" required>Địa chỉ</x-admin.input-label>
                                    <x-admin.input-text name="address" placeholder="Nhập địa chỉ" />
                                    <x-admin.input-error name="address" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="logo">Logo</x-admin.input-label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('logo') is-invalid @enderror"
                                            id="logo" name="logo" accept="image/*">
                                        <label class="custom-file-label" for="logo">Chọn file</label>
                                    </div>
                                    <small class="form-text text-muted">Chọn logo đại diện cho nhà cung cấp.</small>
                                    <div id="logo-preview" class="mt-2" style="display: none;">
                                        <img src="" class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                    <x-admin.input-error name="logo" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="description">Mô tả</x-admin.input-label>
                                    <x-admin.input-textarea name="description" rows="4"
                                        placeholder="Nhập mô tả"></x-admin.input-textarea>
                                    <x-admin.input-error name="description" />
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status"
                                            value="1" {{ old('status', 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">Hoạt động</label>
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

@push('scripts')
    <script>
        $(function() {
            // Thumbnail preview
            $('#logo').change(function() {
                const file = this.files[0];
                if (file) {
                    const objectUrl = URL.createObjectURL(file);
                    $('#logo-preview').show();
                    $('#logo-preview img').attr('src', objectUrl);
                } else {
                    $('#logo-preview').hide();
                }
            });
        });
    </script>
@endpush
