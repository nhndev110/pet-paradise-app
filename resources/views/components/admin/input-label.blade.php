@props(['name' => '', 'class' => ''])

<label for="{{ $name }}" class="{{ $class }} {{ $attributes->has('required') ? 'required' : '' }}">
    {{ $slot }}
</label>
