@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách sản phẩm</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-tool bg-primary">
                            <i class="fas fa-plus"></i>
                            <span class="ml-1">Thêm mới</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="products-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 300px;">Sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Giá bán</th>
                                    <th>SL</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 80px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="img-thumbnail mr-2" width="50">
                                            <span>{{ $product->name }}</span>
                                        </td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($product->price) }} VNĐ</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>
                                            @if ($product->status)
                                                <span class="badge badge-success">Hiển thị</span>
                                            @else
                                                <span class="badge badge-danger">Ẩn</span>
                                            @endif
                                            @if ($product->featured)
                                                <span class="badge badge-primary">Nổi bật</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
            $('#products-table').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": true,
                "searching": false,
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
