<a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-info">
    <i class="fas fa-pencil-alt"></i>
</a>
<form class="d-inline delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">
        <i class="fas fa-trash"></i>
    </button>
</form>
