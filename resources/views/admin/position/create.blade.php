@extends('admin.layouts.app')

@section('title', 'Thêm chức vụ mới')

@section('content')
    <form action="{{ route('admin.positions.store') }}" method="POST">
        @csrf
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.positions.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Thêm chức vụ mới</h1>
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
                                <h3 class="card-title">Thông tin chức vụ</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <x-admin.input-label name="name" required>Tên chức vụ</x-admin.input-label>
                                    <x-admin.input-text name="name" placeholder="Nhập tên chức vụ" />
                                    <x-admin.input-error name="name" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="description">Mô tả</x-admin.input-label>
                                    <x-admin.input-textarea name="description" rows="4"
                                        placeholder="Nhập mô tả chức vụ">
                                    </x-admin.input-textarea>
                                    <x-admin.input-error name="description" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="is_active">Trạng thái</x-admin.input-label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                            value="1" checked>
                                        <label class="custom-control-label" for="is_active">Kích hoạt</label>
                                    </div>
                                    <x-admin.input-error name="is_active" />
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
        $(function() {});
    </script>
@endpush
