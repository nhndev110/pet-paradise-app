@props(['name', 'value'])

<label for="{{ $name }}" class="{{ $attributes->has('required') ? 'required' : '' }}">
    {{ $value ?? $slot }}
</label>
