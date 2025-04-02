@extends('admin.layouts.app')

@section('title', 'Quản lý nhà cung cấp')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách nhà cung cấp</h3>
                </div>
                <div class="card-body">
                    <x-admin.alert-message />

                    {{ $dataTable->table(['class' => 'table table-bordered table-striped dt-responsive nowrap']) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <x-admin.datatables-styles />
@endpush

@push('scripts')
    <x-admin.datatables-scripts />
    {!! $dataTable->scripts(attributes: ['type' => 'module']) !!}

    <script>
        $(function() {
            $('#suppliers-table').on('submit', '.delete-form', function(e) {
                e.preventDefault();

                if (confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?')) {
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

                                $('#suppliers-table').DataTable().ajax.reload();
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
