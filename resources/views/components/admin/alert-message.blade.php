@foreach (['success' => 'success', 'error' => 'danger'] as $key => $class)
    @if (session($key))
        <div class="alert alert-{{ $class }} alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa fa-{{ $key == 'success' ? 'check-circle' : 'exclamation-circle' }} mr-2"></i>
                {{ session($key) }}
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endforeach
