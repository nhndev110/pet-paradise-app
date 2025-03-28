@extends('admin.layouts.app')

@section('title', 'Quản lý nhà cung cấp')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách nhà cung cấp</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-tool bg-primary">
                            <i class="fas fa-plus"></i>
                            <span class="ml-1">Thêm mới</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="suppliers-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tên nhà cung cấp</th>
                                <th style="width: 200px;">Email</th>
                                <th style="width: 150px;">Số điện thoại</th>
                                <th style="width: 80px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}"
                                            class="btn btn-sm btn-info" title="Sửa">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Không có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $('#suppliers-table').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                "searching": true,
                "info": true,
                "ordering": true,
                "order": [],
                "language": {
                    "search": "Tìm kiếm:",
                    "zeroRecords": "Không tìm thấy dữ liệu phù hợp",
                    "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    "infoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                    "infoFiltered": "(được lọc từ _MAX_ mục)",
                    "loadingRecords": "Đang tải...",
                    "processing": "Đang xử lý...",
                    "lengthMenu": "Hiển thị _MENU_ mục",
                    "paginate": {
                        "first": "<<",
                        "last": ">>",
                        "next": ">",
                        "previous": "<",
                    },
                },
            });
        });
    </script>
@endpush
