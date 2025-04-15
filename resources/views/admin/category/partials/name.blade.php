<div class="category-name">
    <div class="d-flex justify-content-between align-items-center">
        {{ $category->name }}
        <div class="btn-group btn-group-sm">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-edit"></i>
            </a>
            <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="{{ $category->id }}">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    </div>

    @if ($category->children->count() > 0)
        <div class="category-children pl-4 mt-2">
            @include('admin.category.partials.child-categories', [
                'categories' => $category->children,
            ])
        </div>
    @endif
</div>
