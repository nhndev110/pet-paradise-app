@props(['name', 'required' => false])

<select id="{{ $name }}" name="{{ $name }}"
    {{ $attributes->merge([
        'class' => 'form-control custom-select' . ($errors->has($name) ? ' is-invalid' : ''),
    ]) }}>
    {{ $slot }}
</select>
