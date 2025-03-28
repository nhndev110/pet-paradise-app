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
                            <label for="name" class="required">Tên danh mục</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $category->name) }}" placeholder="Nhập tên danh mục">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug" class="required">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $category->slug) }}" placeholder="slug-danh-muc">
                            <small class="form-text text-muted">Để trống để tự động tạo từ tên danh mục.</small>
                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                            @error('parent_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="4" placeholder="Nhập mô tả danh mục">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span class="ml-1">Lưu</span>
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i>
                            <span class="ml-1">Huỷ</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/select2/js/i18n/vi.js') }}"></script>
    <script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                    width: "100%",
                    theme: "bootstrap4",
                    language: "vi"
                })
                .on("select2:open", function(ev) {
                    $(`[aria-controls="select2-${ev.target.id}-results"]`)[0].focus();
                });

            bsCustomFileInput.init();

            $('#image').change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#image-preview').html('<img src="' + event.target.result +
                            '" class="img-thumbnail mt-2" width="200">');
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('#name').keyup(function() {
                $('#slug').val(convertToSlug($(this).val()));
            });

            function convertToSlug(text) {
                // Xử lý riêng các ký tự đ/Đ trước khi chuẩn hóa
                text = text.replace(/[đĐ]/g, 'd');

                // Chuyển đổi các ký tự tiếng Việt sang không dấu
                text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

                // Thay thế các ký tự đặc biệt và khoảng trắng
                text = text.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Loại bỏ các ký tự đặc biệt
                    .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
                    .replace(/-+/g, '-') // Loại bỏ nhiều dấu gạch ngang liên tiếp
                    .trim(); // Loại bỏ khoảng trắng đầu/cuối

                return text;
            }
        });
    </script>
@endpush
