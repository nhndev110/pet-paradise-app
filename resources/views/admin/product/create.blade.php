@extends('admin.layouts.app')

@section('title', 'Thêm mới sản phẩm')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin sản phẩm</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-tool bg-secondary">
                            <i class="fas fa-list"></i>
                            <span class="ml-1">Danh sách sản phẩm</span>
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <x-admin.input-label name="name" value="Tên sản phẩm" required />
                                    <x-admin.input-text name="name" placeholder="Nhập tên sản phẩm" />
                                    <x-admin.input-error name="name" />
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="slug" value="Slug" required />
                                    <x-admin.input-text name="slug" placeholder="Nhập slug hoặc để tự động tạo" />
                                    <x-admin.input-error name="slug" />
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-admin.input-label name="category_id" value="Danh mục" required />
                                            <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id">
                                                <option value="">-- Chọn danh mục --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-admin.input-error name="category_id" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-admin.input-label name="supplier_id" value="Nhà cung cấp" />
                                            <select class="form-control select2 @error('supplier_id') is-invalid @enderror"
                                                id="supplier_id" name="supplier_id">
                                                <option value="">-- Chọn nhà cung cấp --</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-admin.input-error name="supplier_id" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-admin.input-label name="price" value="Giá bán" required />
                                            <div class="input-group">
                                                <x-admin.input-text name="price" placeholder="Nhập giá bán"
                                                    class="number-separator text-left" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                            </div>
                                            <x-admin.input-error name="price" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-admin.input-label name="sku" value="SKU" required />
                                            <x-admin.input-text name="sku" placeholder="Nhập giá bán" />
                                            <x-admin.input-error name="sku" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <x-admin.input-label name="stock" value="Số lượng" required />
                                            <x-admin.input-text type="number" name="stock" placeholder="Nhập số lượng"
                                                min="0" />
                                            <x-admin.input-error name="stock" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <x-admin.input-label name="description" value="Chi tiết sản phẩm" />
                                    <x-admin.input-textarea name="description" rows="5"
                                        placeholder="Nhập chi tiết sản phẩm" class="editor"></x-admin.input-textarea>
                                    <x-admin.input-error name="description" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <x-admin.input-label name="thumbnail" value="Hình ảnh chính" required />
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                                id="thumbnail" name="thumbnail" accept="image/*"
                                                value="{{ old('thumbnail') }}">
                                            <label class="custom-file-label" for="thumbnail">Chọn ảnh</label>
                                        </div>
                                    </div>
                                    <x-admin.input-error name="thumbnail" />
                                    <div class="mt-2" id="thumbnail-preview-container" style="display: none;">
                                        <img id="thumbnail-preview" src="#" alt="Preview" class="img-thumbnail"
                                            style="max-height: 200px;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="gallery">Thư viện ảnh</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('gallery') is-invalid @enderror"
                                                id="gallery" name="gallery[]" accept="image/*" multiple>
                                            <label class="custom-file-label" for="gallery">Chọn nhiều ảnh</label>
                                        </div>
                                    </div>
                                    <x-admin.input-error name="gallery" />
                                    <div class="mt-2" id="gallery-preview-container">
                                        <div class="row" id="gallery-preview"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select class="form-control custom-select @error('status') is-invalid @enderror"
                                        id="status" name="status">
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>
                                            Hiển thị
                                        </option>
                                        <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>
                                            Ẩn
                                        </option>
                                    </select>
                                    <x-admin.input-error name="status" />
                                </div>

                                <div class="form-group">
                                    <label>Sản phẩm nổi bật</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="featured"
                                            name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="featured" style="font-weight: 500">
                                            Hiển thị sản phẩm nổi bật
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span class="ml-1">Lưu</span>
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default">
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
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <script>
        let gallery = new DataTransfer();

        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();

                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.editor').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $('#name').keyup(function() {
                $('#slug').val(convertToSlug($(this).val()));
            });

            $('#thumbnail').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#thumbnail-preview').attr('src', e.target.result);
                        $('#thumbnail-preview-container').show();
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('#gallery').on('change', function() {
                const newFiles = this.files;

                for (let i = 0; i < newFiles.length; i++) {
                    gallery.items.add(newFiles[i]);

                    const file = newFiles[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#gallery-preview').append(`
                            <div class="col-md-4 mb-2">
                                <div class="position-relative">
                                    <a href="${e.target.result}" data-toggle="lightbox" data-gallery="mixedgallery">
                                        <img src="${e.target.result}" class="img-thumbnail" style="height: 100px;">
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-danger position-absolute"
                                        style="top: -6px; right: -6px;"
                                        onclick="removeImage(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        `);
                    }

                    reader.readAsDataURL(file);
                }

                document.getElementById('gallery').files = gallery.files;
            });
        });

        function removeImage(button) {
            const removedIndex = $(button).closest('.col-md-4').index();

            gallery.items.remove(removedIndex);

            document.getElementById('gallery').files = gallery.files;

            $(button).closest('.col-md-4').remove();
        }
    </script>
@endpush
