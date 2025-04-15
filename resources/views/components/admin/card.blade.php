@props(['title' => '', 'collapsed' => false, 'class' => ''])

<div class="card {{ $class }} {{ $collapsed ? 'collapsed-card' : '' }}">
    <div class="card-header cursor-pointer" data-card-widget="collapse">
        @if ($title)
            <h3 class="card-title">{{ $title }}</h3>
        @endif
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
