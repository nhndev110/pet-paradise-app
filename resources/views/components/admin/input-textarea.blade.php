@props(['name', 'rows' => 4, 'placeholder' => '', 'error', 'class' => ''])

<textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}"
    class="form-control @error('{{ $name }}') is-invalid @enderror {{ $class }}"
    placeholder="{{ $placeholder }}">{{ old($name, $slot) }}</textarea>
