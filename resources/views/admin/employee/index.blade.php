@extends('admin.layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý nhân viên</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <button type="button" class="btn btn-info rounded-pill mr-1"
                            onclick="$('#employees-table').DataTable().ajax.reload();">
                            <i class="fas fa-sync-alt"></i>
                            <span class="ml-1">Làm mới</span>
                        </button>
                        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary rounded-pill">
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
                        <form method="GET" action="{{ route('admin.employees.index') }}" id="search-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Tên nhân viên</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', request()->name) }}" placeholder="Nhập tên nhân viên" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ old('email', request()->email) }}" placeholder="Nhập email" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ old('phone', request()->phone) }}" placeholder="Nhập số điện thoại" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Chức vụ</label>
                                        <select class="form-control" id="position" name="position">
                                            <option value="">-- Tất cả --</option>
                                            <option value="manager"
                                                {{ request()->position == 'manager' ? 'selected' : '' }}>
                                                Quản lý
                                            </option>
                                            <option value="staff" {{ request()->position == 'staff' ? 'selected' : '' }}>
                                                Nhân viên
                                            </option>
                                            <option value="groomer"
                                                {{ request()->position == 'groomer' ? 'selected' : '' }}>
                                                Nhân viên cắt tỉa
                                            </option>
                                            <option value="veterinarian"
                                                {{ request()->position == 'veterinarian' ? 'selected' : '' }}>
                                                Bác sĩ thú y
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Trạng thái</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">-- Tất cả --</option>
                                            <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>
                                                Đang làm việc
                                            </option>
                                            <option value="inactive"
                                                {{ request()->status == 'inactive' ? 'selected' : '' }}>
                                                Đã nghỉ việc
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department">Phòng ban</label>
                                        <select class="form-control" id="department" name="department">
                                            <option value="">-- Tất cả --</option>
                                            <option value="sales"
                                                {{ request()->department == 'sales' ? 'selected' : '' }}>
                                                Phòng bán hàng
                                            </option>
                                            <option value="services"
                                                {{ request()->department == 'services' ? 'selected' : '' }}>
                                                Phòng dịch vụ
                                            </option>
                                            <option value="admin"
                                                {{ request()->department == 'admin' ? 'selected' : '' }}>
                                                Phòng hành chính
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách nhân viên</h3>
                        </div>

                        <div class="card-body">
                            {{ $dataTable->table(['class' => 'table table-bordered table-striped dt-responsive nowrap w-100']) }}
                        </div>
                    </div>
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
            $('#employees-table').on('submit', '.delete-form', function(e) {
                e.preventDefault();

                if (confirm('Bạn có chắc chắn muốn xóa nhân viên này?')) {
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

                                $('#employees-table').DataTable().ajax.reload();
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
