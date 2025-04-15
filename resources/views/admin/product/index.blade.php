@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý sản phẩm</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <button class="btn btn-info rounded-pill mr-1"
                            onclick="$('#products-table').DataTable().ajax.reload();">
                            <i class="fas fa-sync-alt"></i>
                            <span class="ml-1">Làm mới</span>
                        </button>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill">
                            <i class="fas fa-plus"></i>
                            <span class="ml-1">Thêm mới</span>
                        </a>
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

                    <x-admin.search-panel>
                        <form method="GET" action="{{ route('admin.products.index') }}" id="search-form">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Tên sản phẩm</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', request()->name) }}" placeholder="Nhập tên sản phẩm" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_id">Danh mục</label>
                                        <select class="form-control" id="category_id" name="category_id">
                                            <option value="">-- Tất cả danh mục --</option>
                                            @foreach ($categories ?? [] as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="supplier_id">Nhà cung cấp</label>
                                        <select class="form-control" id="supplier_id" name="supplier_id">
                                            <option value="">-- Tất cả nhà cung cấp --</option>
                                            @foreach ($suppliers ?? [] as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ request()->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="min_price">Giá từ</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="min_price" name="min_price"
                                                value="{{ old('min_price', request()->min_price) }}"
                                                placeholder="Giá thấp nhất" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="max_price">Giá đến</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="max_price" name="max_price"
                                                value="{{ old('max_price', request()->max_price) }}"
                                                placeholder="Giá cao nhất" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Trạng thái</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">-- Tất cả trạng thái --</option>
                                            <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>
                                                Đang hoạt động
                                            </option>
                                            <option value="inactive"
                                                {{ request()->status == 'inactive' ? 'selected' : '' }}>
                                                Không hoạt động
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-center mb-0">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-search"></i>
                                            <span class="ml-1">Tìm kiếm</span>
                                        </button>
                                        <button type="reset" class="btn btn-secondary ml-2 px-4">
                                            <i class="fas fa-redo"></i>
                                            <span class="ml-1">Đặt lại</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </x-admin.search-panel>

                    <x-admin.card title="Danh sách sản phẩm">
                        {{ $dataTable->table(['class' => 'table table-bordered table-striped dt-responsive nowrap w-100']) }}
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <x-admin.datatables-styles />
@endpush

@push('scripts')
    <x-admin.datatables-scripts />
    {{ $dataTable->scripts() }}

    <script>
        $(function() {
            $('#products-table').on('submit', '.delete-form', function(e) {
                e.preventDefault();

                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này ?')) {
                    const form = $(this);

                    $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            data: form.serializeArray(),
                        })
                        .done(function(resp) {
                            if (resp.status === 'success') {
                                Toast.fire({
                                    icon: 'success',
                                    title: resp.message,
                                });

                                $('#products-table').DataTable().ajax.reload();
                            } else {
                                alert(resp.message);
                            }
                        })
                        .fail(function(xhr) {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        });
                }
            });
        });
    </script>
@endpush
