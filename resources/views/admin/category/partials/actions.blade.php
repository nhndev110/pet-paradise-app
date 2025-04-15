<div class="dropdown">
    <button class="btn btn-default btn-sm" type="button" data-toggle="dropdown" aria-expanded="false"
        style="height: 35px; width: 35px;">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">
            <i class="fas fa-pencil-alt"></i>
            <span class="ml-1">Sửa</span>
        </a>
        <form class="dropdown-item p-0 delete-form" action="{{ route('admin.categories.destroy', $category->id) }}"
            method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="dropdown-item text-danger">
                <i class="fas fa-trash"></i>
                <span class="ml-1">Xóa</span>
            </button>
        </form>
    </div>
</div>
