@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.categories.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Chỉnh sửa danh mục</h1>
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
                                data-target="#deleteCategoryModal">
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
                                <h3 class="card-title">Thông tin danh mục: {{ $category->name }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <x-admin.input-label name="name" required>Tên danh mục</x-admin.input-label>
                                    <x-admin.input-text name="name" value="{{ $category->name }}"
                                        placeholder="Nhập tên danh mục" />
                                    <x-admin.input-error name="name" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="slug">Slug</x-admin.input-label>
                                    <x-admin.input-text name="slug" value="{{ $category->slug }}"
                                        placeholder="slug-danh-muc" />
                                    <small class="form-text text-muted">Để trống để tự động tạo từ tên danh mục.</small>
                                    <x-admin.input-error name="slug" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="thumbnail">Hình ảnh</x-admin.input-label>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail" name="thumbnail" accept="image/*">
                                        <label class="custom-file-label" for="thumbnail">Chọn file</label>
                                    </div>
                                    <small class="form-text text-muted">Chọn hình ảnh đại diện cho danh mục.</small>
                                    <div id="thumbnail-preview" class="mt-2">
                                        <img src="{{ asset('storage/' . $category->thumbnail) }}" class="img-thumbnail"
                                            style="max-height: 200px;">
                                    </div>
                                    <x-admin.input-error name="thumbnail" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="parent_id">Danh mục cha</x-admin.input-label>
                                    <select class="form-control select2 @error('parent_id') is-invalid @enderror"
                                        id="parent_id" name="parent_id">
                                        <option value="">Không có</option>
                                        @foreach ($categories ?? [] as $item)
                                            @if ($item->id !== $category->id)
                                                <option value="{{ $item->id }}"
                                                    {{ old('parent_id', $category->parent_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <x-admin.input-error name="parent_id" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="description">Mô tả</x-admin.input-label>
                                    <x-admin.input-textarea name="description" rows="4"
                                        placeholder="Nhập mô tả danh mục">
                                        {{ $category->description }}
                                    </x-admin.input-textarea>
                                    <small class="form-text text-muted">Mô tả ngắn về danh mục.</small>
                                    <x-admin.input-error name="description" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Xác nhận xoá danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xoá danh mục "{{ $category->name }}" không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xoá danh mục</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(function() {
            $('#thumbnail').change(function() {
                const file = this.files[0];
                if (file) {
                    const objectUrl = URL.createObjectURL(file);
                    $('#thumbnail-preview').show();
                    $('#thumbnail-preview img').attr('src', objectUrl);
                } else {
                    $('#thumbnail-preview').hide();
                }
            });

            $('#name').keyup(function() {
                $('#slug').val(convertToSlug($(this).val()));
            });
        });
    </script>
@endpush
