<ul class="list-unstyled">
    @foreach ($categories as $childCategory)
        <li class="mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ $childCategory->name }}</div>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.categories.edit', $childCategory->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="{{ $childCategory->id }}">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>

            @if (isset($childCategory->children) && $childCategory->children->count() > 0)
                <div class="category-children pl-4 mt-2">
                    @include('admin.category.partials.child-categories', [
                        'categories' => $childCategory->children,
                    ])
                </div>
            @endif
        </li>
    @endforeach
</ul>
