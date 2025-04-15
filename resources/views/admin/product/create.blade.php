@extends('admin.layouts.app')

@section('title', 'Thêm mới sản phẩm')

@section('content')
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.products.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Thêm mới sản phẩm</h1>
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
                        <x-admin.card title="Thông tin sản phẩm">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <x-admin.input-label name="name" required>Tên sản phẩm</x-admin.input-label>
                                        <x-admin.input-text name="name" placeholder="Nhập tên sản phẩm" />
                                        <x-admin.input-error name="name" />
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="slug" required>Slug</x-admin.input-label>
                                        <x-admin.input-text name="slug" placeholder="Nhập slug hoặc để tự động tạo" />
                                        <small class="form-text text-muted">Để trống để tự động tạo từ tên sản
                                            phẩm.</small>
                                        <x-admin.input-error name="slug" />
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="category_id" required>
                                            Danh mục
                                        </x-admin.input-label>
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

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label name="stock" required>
                                                    Tồn kho
                                                </x-admin.input-label>
                                                <x-admin.input-text type="number" name="stock" placeholder="Nhập tồn kho"
                                                    min="0" />
                                                <x-admin.input-error name="stock" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label name="sku">SKU</x-admin.input-label>
                                                <x-admin.input-text name="sku" placeholder="Nhập mã SKU" />
                                                <x-admin.input-error name="sku" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label name="supplier_id">
                                                    Nhà cung cấp
                                                </x-admin.input-label>
                                                <select
                                                    class="form-control select2 @error('supplier_id') is-invalid @enderror"
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
                                                <x-admin.input-label name="cost_price" required>
                                                    Giá vốn
                                                </x-admin.input-label>
                                                <div class="input-group">
                                                    <x-admin.input-text name="cost_price" class="number-separator text-left"
                                                        placeholder="Nhập giá vốn" min="0" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">đ</span>
                                                    </div>
                                                </div>
                                                <x-admin.input-error name="cost_price" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label name="sell_price" required>
                                                    Giá bán
                                                </x-admin.input-label>
                                                <div class="input-group">
                                                    <x-admin.input-text name="sell_price" placeholder="Nhập giá bán"
                                                        class="number-separator text-left" min="0" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">đ</span>
                                                    </div>
                                                </div>
                                                <x-admin.input-error name="sell_price" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label>Lợi nhuận</x-admin.input-label>
                                                <div class="input-group">
                                                    <input type="text" readonly
                                                        class="form-control number-separator text-left" value="0"
                                                        id="profit" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">đ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="description">Chi tiết sản phẩm</x-admin.input-label>
                                        <x-admin.input-textarea name="description" rows="5"
                                            placeholder="Nhập chi tiết sản phẩm" class="editor"></x-admin.input-textarea>
                                        <x-admin.input-error name="description" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <x-admin.input-label name="thumbnail" required>Hình ảnh
                                            chính</x-admin.input-label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                                id="thumbnail" name="thumbnail" accept="image/*"
                                                value="{{ old('thumbnail') }}">
                                            <label class="custom-file-label" for="thumbnail">Chọn ảnh</label>
                                        </div>
                                        <x-admin.input-error name="thumbnail" />
                                        <div class="mt-2" id="thumbnail-preview-container" style="display: none;">
                                            <img id="thumbnail-preview" src="#" alt="Preview"
                                                class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="gallery">Thư viện ảnh</x-admin.input-label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('gallery') is-invalid @enderror"
                                                id="gallery" name="gallery[]" accept="image/*" multiple>
                                            <label class="custom-file-label" for="gallery">Chọn nhiều ảnh</label>
                                        </div>
                                        <x-admin.input-error name="gallery" />
                                        <div class="mt-2" id="gallery-preview-container">
                                            <div class="row" id="gallery-preview"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="status">Trạng thái</x-admin.input-label>
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
                                        <x-admin.input-label name="featured">Sản phẩm nổi bật</x-admin.input-label>
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
                        </x-admin.card>
                    </div>
                </div>
            </div>
        </section>
    </form>
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

            // Calculate profit function
            function calculateProfit() {
                // Get values and remove currency formatting
                let costPrice = $('input[name="cost_price"]').val().replace(/[,.]/g, '') || 0;
                let sellPrice = $('input[name="sell_price"]').val().replace(/[,.]/g, '') || 0;

                // Convert to numbers and calculate profit
                costPrice = parseInt(costPrice);
                sellPrice = parseInt(sellPrice);
                let profit = sellPrice - costPrice;

                // Format the profit with thousand separators and update the field
                $('#profit').val(profit);
            }

            // Calculate profit when cost price or sell price changes
            $('input[name="cost_price"], input[name="sell_price"]').on('input', function() {
                calculateProfit();
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
