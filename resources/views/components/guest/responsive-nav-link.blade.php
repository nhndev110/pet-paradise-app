@props(['active'])

@php
  $classes =
      $active ?? false
          ? 'd-block w-100 ps-3 pe-4 py-2 border-start border-4 border-primary text-start fs-6 fw-medium text-primary bg-light focus-visible:outline-none transition'
          : 'd-block w-100 ps-3 pe-4 py-2 border-start border-4 border-transparent text-start fs-6 fw-medium text-secondary hover:text-dark hover:bg-light hover:border-secondary focus-visible:outline-none transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
  {{ $slot }}
</a>
