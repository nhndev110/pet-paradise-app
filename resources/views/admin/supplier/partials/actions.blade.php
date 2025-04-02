<a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary">
    <i class="fas fa-pencil-alt"></i>
</a>
<form class="d-inline delete-form" action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">
        <i class="fas fa-trash"></i>
    </button>
</form>
