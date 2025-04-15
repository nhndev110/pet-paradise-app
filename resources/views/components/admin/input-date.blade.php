@props(['name', 'value' => '', 'format' => 'dd/mm/yyyy'])

<div class="input-group date" id="{{ $name }}" data-target-input="nearest">
    <input type="text" id="{{ $name }}" name="{{ $name }}"
        class="form-control {{ $attributes->get('class') }}" data-inputmask-alias="datetime"
        data-inputmask-inputformat="{{ $format }}" placeholder="{{ $format }}" data-mask
        data-target="#{{ $name }}" value="{{ old($name, $value) }}" autocomplete="off"
        {{ $attributes->except(['class']) }} />
    <div class="input-group-append bg-white" data-target="#{{ $name }}" data-toggle="datetimepicker">
        <div class="input-group-text bg-white"><i class="fa fa-calendar"></i></div>
    </div>
</div>
