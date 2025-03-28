@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-2 bg-white'])

@php
  $alignmentClasses = match ($align) {
      'left' => 'dropdown-menu-start',
      'top' => 'dropdown-menu-top',
      default => 'dropdown-menu-end',
  };

  $width = match ($width) {
      '48' => '',
      default => "style=\"width: {$width}\"",
  };
@endphp

<div class="dropdown position-relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
  <div @click="open = ! open">
    {{ $trigger }}
  </div>

  <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="dropdown-menu position-absolute mt-2 {{ $alignmentClasses }}" {!! $width !!} style="display: none;"
    @click="open = false">
    <div class="dropdown-menu show border shadow {{ $contentClasses }}">
      {{ $content }}
    </div>
  </div>
</div>
