@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Thông tin danh mục: {{ $category->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-tool bg-secondary">
                            <i class="fas fa-list"></i>
                            <span class="ml-1">Danh sách danh mục</span>
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <x-admin.input-label name="name" value="Tên danh mục" required="true" />
                            <x-admin.input-text name="name" value="{{ $category->name }}"
                                placeholder="Nhập tên danh mục" />
                            <x-admin.input-error name="name" />
                        </div>

                        <div class="form-group">
                            <x-admin.input-label name="slug" value="Slug" required="true" />
                            <x-admin.input-text name="slug" value="{{ $category->slug }}" placeholder="slug-danh-muc" />
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
                            <div id="thumbnail-preview" class="mt-2">
                                <img src="{{ asset('storage/' . $category->thumbnail) }}" class="img-thumbnail"
                                    style="max-height: 200px;">
                            </div>
                            <x-admin.input-error name="thumbnail" />
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Danh mục cha</label>
                            <select class="form-control select2 @error('parent_id') is-invalid @enderror" id="parent_id"
                                name="parent_id">
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
                            <x-admin.input-label name="description" value="Mô tả" />
                            <x-admin.input-textarea name="description" rows="4" placeholder="Nhập mô tả danh mục">
                                {{ $category->description }}
                            </x-admin.input-textarea>
                            <small class="form-text text-muted">Mô tả ngắn về danh mục.</small>
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
