@extends('admin.layouts.app')

@section('title', 'Thêm danh mục mới')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Thông tin danh mục</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-tool bg-secondary">
                            <i class="fas fa-list"></i>
                            <span class="ml-1">Danh sách danh mục</span>
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <x-admin.input-label name="name" value="Tên danh mục" required />
                            <x-admin.input-text name="name" placeholder="Nhập tên danh mục" />
                            <x-admin.input-error name="name" />
                        </div>

                        <div class="form-group">
                            <x-admin.input-label name="slug" value="Slug" required />
                            <x-admin.input-text name="slug" placeholder="slug-danh-muc" />
                            <small class="form-text text-muted">Để trống để tự động tạo từ tên danh mục.</small>
                            <x-admin.input-error name="slug" />
                        </div>

                        <div class="form-group">
                            <x-admin.input-label name="thumbnail" value="Hình ảnh" required />
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
                            <x-admin.input-label name="parent_id" value="Danh mục cha" />
                            <select class="form-control select2 @error('parent_id') is-invalid @enderror" id="parent_id"
                                name="parent_id">
                                <option value="">Không có</option>
                                @foreach ($categories ?? [] as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-admin.input-error name="parent_id" />
                        </div>

                        <div class="form-group">
                            <x-admin.input-label name="description" value="Mô tả" />
                            <x-admin.input-textarea name="description" rows="4" placeholder="Nhập mô tả danh mục">
                            </x-admin.input-textarea>
                            <x-admin.input-error name="description" />
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span class="ml-1">Lưu</span>
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i>
                            <span class="ml-1">Quay lại</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#name').keyup(function() {
                $('#slug').val(convertToSlug($(this).val()));
            });

            // Thumbnail preview
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
