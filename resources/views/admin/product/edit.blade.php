@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a class="text-secondary" href="{{ route('admin.products.index') }}" style="font-size: 26px;">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                        <h1 class="d-inline ml-2">Chỉnh sửa sản phẩm</h1>
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
                            <a href="#" class="btn btn-danger rounded-pill" data-toggle="modal"
                                data-target="#deleteProductModal">
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

                        <x-admin.card title="Thông tin sản phẩm: {{ $product->name }}">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <x-admin.input-label name="name" required>Tên sản phẩm</x-admin.input-label>
                                        <x-admin.input-text name="name" placeholder="Nhập tên sản phẩm" :value="$product->name"
                                            autocomplete="off" />
                                        <x-admin.input-error name="name" />
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="slug" required>Slug</x-admin.input-label>
                                        <x-admin.input-text name="slug" placeholder="Nhập slug hoặc để tự động tạo"
                                            :value="$product->slug" />
                                        <x-admin.input-error name="slug" />
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="category_id" required>
                                            Danh mục
                                        </x-admin.input-label>
                                        <x-admin.input-select class="select2" name="category_id">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </x-admin.input-select>
                                        <x-admin.input-error name="category_id" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label name="stock" required>
                                                    Tồn kho
                                                </x-admin.input-label>
                                                <x-admin.input-text name="stock" placeholder="Nhập tồn kho"
                                                    :value="$product->stock" type="number" min="0" />
                                                <x-admin.input-error name="stock" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label name="sku">SKU</x-admin.input-label>
                                                <x-admin.input-text name="sku" placeholder="Nhập mã SKU"
                                                    :value="$product->sku" />
                                                <x-admin.input-error name="sku" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label name="supplier_id">
                                                    Nhà cung cấp
                                                </x-admin.input-label>
                                                <x-admin.input-select class="select2" name="supplier_id">
                                                    <option value="">-- Chọn nhà cung cấp --</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}"
                                                            {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                            {{ $supplier->name }}
                                                        </option>
                                                    @endforeach
                                                </x-admin.input-select>
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
                                                        placeholder="Nhập giá vốn" :value="$product->cost_price" min="0"
                                                        inputGroupText="đ" />
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
                                                        class="number-separator text-left" min="0" :value="$product->sell_price"
                                                        inputGroupText="đ" />
                                                </div>
                                                <x-admin.input-error name="sell_price" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <x-admin.input-label>Lợi nhuận</x-admin.input-label>
                                                <div class="input-group">
                                                    <x-admin.input-text readonly
                                                        class="form-control number-separator text-left" value="0"
                                                        inputGroupText="đ" id="profit" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="description">Chi tiết sản phẩm</x-admin.input-label>
                                        <x-admin.input-textarea name="description" class="editor"
                                            placeholder="Nhập chi tiết sản phẩm">{{ $product->description }}</x-admin.input-textarea>
                                        <x-admin.input-error name="description" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <x-admin.input-label name="thumbnail" required>
                                            Hình ảnh chính
                                        </x-admin.input-label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                    class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                                    id="thumbnail" name="thumbnail" accept="image/*">
                                                <label class="custom-file-label" for="thumbnail">Chọn ảnh</label>
                                            </div>
                                        </div>
                                        <x-admin.input-error name="thumbnail" />
                                        <div class="mt-2" id="thumbnail-preview-container">
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" class="img-thumbnail"
                                                style="max-height: 200px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="gallery">Thư viện ảnh</x-admin.input-label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                    class="custom-file-input @error('gallery') is-invalid @enderror"
                                                    id="gallery" name="gallery[]" accept="image/*" multiple>
                                                <label class="custom-file-label" for="gallery">Thêm ảnh</label>
                                            </div>
                                        </div>
                                        <x-admin.input-error name="gallery" />
                                        <div class="mt-2" id="gallery-preview-container">
                                            <div class="row" id="gallery-preview">
                                                @if ($gallery)
                                                    @foreach ($gallery as $image)
                                                        <div class="col-md-4 old-gallery mb-2 gallery-item"
                                                            data-id="old-{{ $loop->index }}">
                                                            <div class="position-relative">
                                                                <a href="{{ asset('storage/' . $image->image_url) }}"
                                                                    data-toggle="lightbox" data-gallery="mixedgallery"
                                                                    data-height="500" data-width="500">
                                                                    <img src="{{ asset('storage/' . $image->image_url) }}"
                                                                        class="img-thumbnail" style="height: 100px;">
                                                                </a>
                                                                <input type="hidden" name="old_gallery[]"
                                                                    value="{{ $image->image_url }}">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger position-absolute"
                                                                    style="top: -6px; right: -6px;"
                                                                    onclick="removeImage(this)">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="status">Trạng thái</x-admin.input-label>
                                        <select class="form-control custom-select @error('status') is-invalid @enderror"
                                            id="status" name="status">
                                            <option value="1"
                                                {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                                                Hiển thị
                                            </option>
                                            <option value="0"
                                                {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
                                                Ẩn
                                            </option>
                                        </select>
                                        <x-admin.input-error name="status" />
                                    </div>

                                    <div class="form-group">
                                        <x-admin.input-label name="featured">Sản phẩm nổi bật</x-admin.input-label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="featured"
                                                name="featured" value="1"
                                                {{ old('featured', $product->featured) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="featured" style="font-weight: 500">
                                                Hiển thị sản phẩm nổi bật
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-admin.card>

                        <x-admin.card title="Sản phẩm liên quan">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                    data-target="#relatedProductsModal">
                                    <i class="fas fa-plus"></i> Thêm sản phẩm liên quan
                                </button>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="relatedProductsTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">STT</th>
                                                <th style="width: 15%">Hình ảnh</th>
                                                <th style="width: 35%">Tên sản phẩm</th>
                                                <th style="width: 15%">SKU</th>
                                                <th style="width: 15%">Giá bán</th>
                                                <th style="width: 15%">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="relatedProductsList">
                                            @foreach ($relatedProductIds ?? [] as $index => $relatedId)
                                                @php
                                                    $relProduct = $allProducts->firstWhere('id', $relatedId);
                                                @endphp
                                                @if ($relProduct)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <img src="{{ asset('storage/' . $relProduct->thumbnail) }}"
                                                                alt="{{ $relProduct->name }}" class="img-thumbnail"
                                                                style="height: 50px;">
                                                        </td>
                                                        <td>{{ $relProduct->name }}</td>
                                                        <td>{{ $relProduct->sku ?? 'N/A' }}</td>
                                                        <td>{{ number_format($relProduct->sell_price) }}đ</td>
                                                        <td>
                                                            <input type="hidden" name="related_products[]"
                                                                value="{{ $relProduct->id }}">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-related-product">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Các sản phẩm được chọn sẽ hiển thị như sản phẩm liên
                                    quan
                                </small>
                            </div>
                        </x-admin.card>

                        <!-- Modal for selecting related products -->
                        <div class="modal fade" id="relatedProductsModal" tabindex="-1" role="dialog"
                            aria-labelledby="relatedProductsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="relatedProductsModalLabel">
                                            Chọn sản phẩm liên quan
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="searchProduct"
                                                        placeholder="Tìm kiếm sản phẩm...">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="form-control" id="filterCategory">
                                                        <option value="">-- Tất cả danh mục --</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary" id="applyFilter">
                                                    <i class="fas fa-filter"></i> Lọc
                                                </button>
                                                <button type="button" class="btn btn-secondary" id="resetFilter">
                                                    <i class="fas fa-sync"></i> Đặt lại
                                                </button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="selectProductsTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="checkAll">
                                                                <label class="custom-control-label"
                                                                    for="checkAll"></label>
                                                            </div>
                                                        </th>
                                                        <th style="width: 15%">Hình ảnh</th>
                                                        <th style="width: 35%">Tên sản phẩm</th>
                                                        <th style="width: 15%">SKU</th>
                                                        <th style="width: 15%">Giá bán</th>
                                                        <th style="width: 15%">Danh mục</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($allProducts as $productItem)
                                                        @if ($productItem->id != $product->id)
                                                            <tr>
                                                                <td>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input product-checkbox"
                                                                            id="product{{ $productItem->id }}"
                                                                            value="{{ $productItem->id }}"
                                                                            data-name="{{ $productItem->name }}"
                                                                            data-sku="{{ $productItem->sku ?? 'N/A' }}"
                                                                            data-thumbnail="{{ $productItem->thumbnail }}"
                                                                            data-price="{{ $productItem->sell_price }}"
                                                                            data-category="{{ $productItem->category_id }}"
                                                                            {{ in_array($productItem->id, $relatedProductIds ?? []) ? 'checked' : '' }}>
                                                                        <label class="custom-control-label"
                                                                            for="product{{ $productItem->id }}"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <img src="{{ asset('storage/' . $productItem->thumbnail) }}"
                                                                        alt="{{ $productItem->name }}"
                                                                        class="img-thumbnail" style="height: 50px;">
                                                                </td>
                                                                <td>{{ $productItem->name }}</td>
                                                                <td>{{ $productItem->sku ?? 'N/A' }}</td>
                                                                <td>{{ number_format($productItem->sell_price) }}đ</td>
                                                                <td>{{ $productItem->category->name ?? 'N/A' }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary" id="addSelectedProducts">
                                            <i class="fas fa-plus"></i> Thêm sản phẩm đã chọn
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
                            <script>
                                $(function() {
                                    // Handle "Check All" functionality
                                    $('#checkAll').change(function() {
                                        $('.product-checkbox:visible').prop('checked', $(this).is(':checked'));
                                    });

                                    // Add selected products button click
                                    $('#addSelectedProducts').click(function() {
                                        let selectedCount = 0;

                                        // Get all checked checkboxes
                                        $('.product-checkbox:checked').each(function() {
                                            const productId = $(this).val();
                                            const productName = $(this).data('name');
                                            const productSku = $(this).data('sku');
                                            const productThumbnail = $(this).data('thumbnail');
                                            const productPrice = $(this).data('price');

                                            // Check if product is already added
                                            if ($(`#relatedProductsList input[value="${productId}"]`).length === 0) {
                                                // Add to related products table
                                                const index = $('#relatedProductsList tr').length + 1;

                                                $('#relatedProductsList').append(`
                                                    <tr>
                                                        <td>${index}</td>
                                                        <td><img src="{{ asset('storage/') }}/${productThumbnail}" alt="${productName}" class="img-thumbnail" style="height: 50px;"></td>
                                                        <td>${productName}</td>
                                                        <td>${productSku}</td>
                                                        <td>${formatNumber(productPrice)}đ</td>
                                                        <td>
                                                            <input type="hidden" name="related_products[]" value="${productId}">
                                                            <button type="button" class="btn btn-sm btn-danger remove-related-product">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                `);
                                                selectedCount++;
                                            }
                                        });

                                        // Close modal
                                        $('#relatedProductsModal').modal('hide');

                                        // Show notification
                                        if (selectedCount > 0) {
                                            toastr.success(`Đã thêm ${selectedCount} sản phẩm liên quan`);
                                        } else {
                                            toastr.info('Không có sản phẩm mới nào được thêm');
                                        }
                                    });

                                    // Remove related product
                                    $(document).on('click', '.remove-related-product', function() {
                                        $(this).closest('tr').remove();

                                        // Re-number the rows
                                        $('#relatedProductsList tr').each(function(index) {
                                            $(this).find('td:first').text(index + 1);
                                        });
                                    });

                                    // Search and filter functionality
                                    $('#applyFilter').click(function() {
                                        filterProducts();
                                    });

                                    $('#resetFilter').click(function() {
                                        $('#searchProduct').val('');
                                        $('#filterCategory').val('');
                                        filterProducts();
                                    });

                                    function filterProducts() {
                                        const searchTerm = $('#searchProduct').val().toLowerCase();
                                        const categoryId = $('#filterCategory').val();

                                        $('#selectProductsTable tbody tr').each(function() {
                                            const productName = $(this).find('td:nth-child(3)').text().toLowerCase();
                                            const productSku = $(this).find('td:nth-child(4)').text().toLowerCase();
                                            const productCategory = $(this).find('input.product-checkbox').data('category');

                                            let showRow = true;

                                            if (searchTerm && !(productName.includes(searchTerm) || productSku.includes(
                                                    searchTerm))) {
                                                showRow = false;
                                            }

                                            if (categoryId && productCategory != categoryId) {
                                                showRow = false;
                                            }

                                            $(this).toggle(showRow);
                                        });
                                    }

                                    // Format number with commas
                                    function formatNumber(number) {
                                        return new Intl.NumberFormat('vi-VN').format(number);
                                    }
                                });
                            </script>
                        @endpush
                    </div>
                </div>
            </div>
        </section>
    </form>

    <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Xác nhận xoá sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xoá sản phẩm "{{ $product->name }}" không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xoá sản phẩm</button>
                    </form>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
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

            $('#image').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview-container').html(
                            `<img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-height: 200px;">`
                        );
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

                console.log(costPrice, sellPrice, profit);

                // Format the profit with thousand separators and update the field
                $('#profit').val(profit);
            }

            // Calculate profit on page load
            calculateProfit();

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
                            <div class="col-md-4 mb-2 gallery-item" data-id="${Date.now() + i}">
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

                        // Reinitialize sortable after adding new items
                        initSortable();
                    }

                    reader.readAsDataURL(file);
                }

                document.getElementById('gallery').files = gallery.files;
            });

            // Initialize sortable
            initSortable();
        });

        function removeImage(element) {
            // Số lượng các ảnh cũ
            const oldGalleryLength = $('.old-gallery').length;

            // Index của ảnh cần xóa sẽ bằng index của phần tử cha .col-md-4 trừ đi số lượng ảnh cũ
            const removedIndex = $(element).closest('.col-md-4').index() - oldGalleryLength;

            // Kiểm tra nếu index của ảnh cần xóa lớn hơn -1 thì xóa phần tử đó khỏi gallery
            if (removedIndex > -1) {
                gallery.items.remove(removedIndex);

                document.getElementById('gallery').files = gallery.files;
            }

            $(element).closest('.col-md-4').remove();
        }

        function initSortable() {
            const galleryEl = document.getElementById('gallery-preview');
            if (!galleryEl.sortableInstance) {
                galleryEl.sortableInstance = Sortable.create(galleryEl, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        // When sorting ends, we need to update the gallery files order
                        updateGalleryOrder();
                    }
                });
            }
        }

        function updateGalleryOrder() {
            // For existing files (old gallery), we don't need to change anything
            // For new files, we need to reorder the gallery DataTransfer object

            // If there are no new files, exit early
            if (gallery.files.length === 0) return;

            const newGallery = new DataTransfer();
            const newItems = document.querySelectorAll('#gallery-preview .gallery-item:not(.old-gallery)');

            // Create a temp array to hold file data and positions
            const filesArray = [];

            // Loop through existing gallery files and save them to array
            for (let i = 0; i < gallery.files.length; i++) {
                filesArray.push({
                    file: gallery.files[i],
                    originalIndex: i
                });
            }

            // Loop through the DOM elements to get new order
            newItems.forEach((item, index) => {
                const originalIndex = Array.from(document.querySelectorAll(
                    '#gallery-preview .gallery-item:not(.old-gallery)')).indexOf(item);
                if (originalIndex >= 0 && originalIndex < filesArray.length) {
                    newGallery.items.add(filesArray[originalIndex].file);
                }
            });

            // Replace the old gallery with the new one
            gallery = newGallery;
            document.getElementById('gallery').files = gallery.files;
        }
    </script>
@endpush
