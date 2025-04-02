@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa nhà cung cấp')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin nhà cung cấp</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-tool bg-secondary">
                            <i class="fas fa-list"></i>
                            <span class="ml-1">Danh sách nhà cung cấp</span>
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <x-admin.input-label name="name" value="Tên nhà cung cấp" required />
                            <x-admin.input-text name="name" placeholder="Nhập tên nhà cung cấp" :value="$supplier->name" />
                            <x-admin.input-error name="name" />
                        </div>

                        <div class="form-group">
                            <x-admin.input-label name="email" value="Email" required />
                            <x-admin.input-text type="email" name="email" placeholder="Nhập email" :value="$supplier->email" />
                            <x-admin.input-error name="email" />
                        </div>

                        <div class="form-group">
                            <x-admin.input-label name="phone" value="Số điện thoại" required />
                            <x-admin.input-text name="phone" placeholder="Nhập số điện thoại" :value="$supplier->phone" />
                            <x-admin.input-error name="phone" />
                        </div>

                        <div class="form-group">
                            <x-admin.input-label name="address" value="Địa chỉ" required />
                            <x-admin.input-text name="address" placeholder="Nhập địa chỉ" :value="$supplier->address" />
                            <x-admin.input-error name="address" />
                        </div>

                        <div class="form-group">
                            <x-admin.input-label name="description" value="Mô tả" />
                            <x-admin.input-textarea name="description" rows="3" placeholder="Nhập mô tả">
                                {{ $supplier->description }}
                            </x-admin.input-textarea>
                            <x-admin.input-error name="description" />
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status"
                                    value="1" {{ old('status', $supplier->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Hoạt động</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span class="ml-1">Lưu</span>
                        </button>
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i>
                            <span class="ml-1">Quay lại</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
