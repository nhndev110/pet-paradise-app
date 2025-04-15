@foreach ($children as $child)
    <option value="{{ $child->id }}"
        {{ (isset($selectedId) && $selectedId == $child->id) || old('parent_id') == $child->id ? 'selected' : '' }}>
        {{ str_repeat('— ', $level) }} {{ $child->name }}
    </option>
    @if ($child->children->isNotEmpty())
        @include('admin.category.partials.category-option', [
            'children' => $child->children,
            'level' => $level + 1,
            'selectedId' => $selectedId ?? null,
            'categoryId' => $categoryId ?? null,
        ])
    @endif
@endforeach
