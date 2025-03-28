@props(['name', 'placeholder' => '', 'class' => '', 'value' => null])

<input class="form-control @error($name) is-invalid @enderror {{ $class }}" id="{{ $name }}"
    name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" autocomplete="off"
    {{ $attributes }} />
