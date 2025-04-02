<a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-info btn-sm">
    <i class="fas fa-pencil-alt"></i>
</a>
<form class="d-inline delete-form" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i>
    </button>
</form>
