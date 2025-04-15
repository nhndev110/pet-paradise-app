@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa nhà cung cấp')

@section('content')
    <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.suppliers.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Chỉnh sửa nhà cung cấp</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <button type="submit" class="btn btn-primary rounded-pill mr-1">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu lại</span>
                            </button>
                            <button type="submit" name="save-continue" class="btn btn-primary rounded-pill mr-1">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu và sửa tiếp</span>
                            </button>
                            <button type="button" class="btn btn-danger rounded-pill" data-toggle="modal"
                                data-target="#deleteSupplierModal">
                                <i class="fas fa-trash"></i>
                                <span class="ml-1">Xóa</span>
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
                                <h3 class="card-title">Thông tin nhà cung cấp: {{ $supplier->name }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <x-admin.input-label name="name" required>Tên nhà cung cấp</x-admin.input-label>
                                    <x-admin.input-text name="name" value="{{ $supplier->name }}"
                                        placeholder="Nhập tên nhà cung cấp" />
                                    <x-admin.input-error name="name" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="email" required>Email</x-admin.input-label>
                                    <x-admin.input-text name="email" value="{{ $supplier->email }}"
                                        placeholder="example@gmail.com" />
                                    <x-admin.input-error name="email" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="phone" required>Số điện thoại</x-admin.input-label>
                                    <x-admin.input-text name="phone" value="{{ $supplier->phone }}"
                                        placeholder="0123456789" />
                                    <x-admin.input-error name="phone" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="address" required>Địa chỉ</x-admin.input-label>
                                    <x-admin.input-text name="address" value="{{ $supplier->address }}"
                                        placeholder="Nhập địa chỉ" />
                                    <x-admin.input-error name="address" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="description">Mô tả</x-admin.input-label>
                                    <x-admin.input-textarea name="description" rows="4"
                                        placeholder="Nhập mô tả nhà cung cấp">{{ $supplier->description }}</x-admin.input-textarea>
                                    <small class="form-text text-muted">Mô tả ngắn về nhà cung cấp (không bắt buộc).</small>
                                    <x-admin.input-error name="description" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <div class="modal fade" id="deleteSupplierModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSupplierModalLabel">Xác nhận xoá nhà cung cấp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xoá nhà cung cấp "{{ $supplier->name }}" không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xoá nhà cung cấp</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Preserve existing styles -->
@endpush

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
