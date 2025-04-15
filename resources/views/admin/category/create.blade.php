@extends('admin.layouts.app')

@section('title', 'Thêm danh mục mới')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.categories.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Thêm danh mục mới</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <button type="submit" class="btn btn-primary rounded-pill mr-1">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu lại</span>
                            </button>
                            <button type="submit" name="save-continue" class="btn btn-primary rounded-pill">
                                <i class="fas fa-save"></i>
                                <span class="ml-1">Lưu và sửa tiếp</span>
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

                        <x-admin.card title="Thông tin danh mục">
                            <div class="form-group">
                                <x-admin.input-label name="name" required>Tên danh mục</x-admin.input-label>
                                <x-admin.input-text name="name" placeholder="Nhập tên danh mục" />
                                <x-admin.input-error name="name" />
                            </div>

                            <div class="form-group">
                                <x-admin.input-label name="slug">Slug</x-admin.input-label>
                                <x-admin.input-text name="slug" placeholder="slug-danh-muc" />
                                <small class="form-text text-muted">Để trống để tự động tạo từ tên danh mục.</small>
                                <x-admin.input-error name="slug" />
                            </div>

                            <div class="form-group">
                                <x-admin.input-label name="thumbnail">Hình ảnh</x-admin.input-label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                        id="thumbnail" name="thumbnail" accept="image/*">
                                    <label class="custom-file-label" for="thumbnail">Chọn file</label>
                                </div>
                                <small class="form-text text-muted">Chọn hình ảnh đại diện cho danh mục.</small>
                                <div id="thumbnail-preview" class="mt-2" style="display: none;">
                                    <img src="" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                                <x-admin.input-error name="thumbnail" />
                            </div>

                            <div class="form-group">
                                <x-admin.input-label name="parent_id">Danh mục cha</x-admin.input-label>
                                <select class="form-control select2 @error('parent_id') is-invalid @enderror" id="parent_id"
                                    name="parent_id">
                                    <option value="">Không có</option>
                                    @foreach ($categoryTree as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @if ($category->children->isNotEmpty())
                                            @include('admin.category.partials.category-option', [
                                                'children' => $category->children,
                                                'level' => 1,
                                            ])
                                        @endif
                                    @endforeach
                                </select>
                                <x-admin.input-error name="parent_id" />
                            </div>

                            <div class="form-group">
                                <x-admin.input-label name="description">Mô tả</x-admin.input-label>
                                <x-admin.input-textarea name="description" rows="4"
                                    placeholder="Nhập mô tả danh mục"></x-admin.input-textarea>
                                <x-admin.input-error name="description" />
                            </div>
                        </x-admin.card>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection

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
        });
    </script>
@endpush
