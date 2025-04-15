@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa chức vụ')

@section('content')
    <form action="{{ route('admin.positions.update', $position->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.positions.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Chỉnh sửa chức vụ</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <button type="submit" class="btn btn-primary rounded-pill mr-1">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu</span>
                            </button>
                            <button type="submit" name="save-continue" class="btn btn-primary rounded-pill mr-1">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu và sửa tiếp</span>
                            </button>
                            <a href="#" class="btn btn-danger rounded-pill" data-toggle="modal"
                                data-target="#deleteModal">
                                <i class="fas fa-trash"></i>
                                <span class="ml-1">Xoá</span>
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

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin chức vụ: {{ $position->name }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <x-admin.input-label name="name" required>Tên chức vụ</x-admin.input-label>
                                    <x-admin.input-text name="name" value="{{ $position->name }}"
                                        placeholder="Nhập tên chức vụ" />
                                    <x-admin.input-error name="name" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="description">Mô tả</x-admin.input-label>
                                    <x-admin.input-textarea name="description" rows="4"
                                        placeholder="Nhập mô tả chức vụ">
                                        {{ $position->description }}
                                    </x-admin.input-textarea>
                                    <x-admin.input-error name="description" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="is_active">Trạng thái</x-admin.input-label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                            value="1" {{ $position->is_active ? 'checked' : '' }}>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xoá chức vụ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xoá chức vụ "{{ $position->name }}" không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    <form action="{{ route('admin.positions.destroy', $position->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xoá chức vụ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {});
    </script>
@endpush
