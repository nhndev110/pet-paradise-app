@props(['name' => null, 'placeholder' => '', 'class' => '', 'value' => null, 'inputGroupText' => null])

<input class="form-control @error($name) is-invalid @enderror {{ $class }}"
    @if ($name) id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}" @else value="{{ $value ?? '' }}" @endif
    placeholder="{{ $placeholder }}" autocomplete="off" {{ $attributes }} />

@if ($inputGroupText)
    <div class="input-group-append">
        <span class="input-group-text">{{ $inputGroupText }}</span>
    </div>
@endif
