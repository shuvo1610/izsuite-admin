{{-- Badge Component --}}
{{-- Usage: @include('components.badge', ['type' => 'active|unused|cancelled|trial', 'label' => '...']) --}}

@php
    $type = $type ?? 'active';
    $label = $label ?? ucfirst($type);
@endphp

<span class="badge badge-{{ $type }}">{{ $label }}</span>
