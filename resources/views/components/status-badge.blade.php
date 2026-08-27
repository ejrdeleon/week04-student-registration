@props(['status' => 'active'])

@php
    $classes = match($status) {
        'active'   => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
        'inactive' => 'bg-amber-100 text-amber-700 ring-amber-200',
        'archived' => 'bg-gray-100 text-gray-500 ring-gray-200',
        default    => 'bg-gray-100 text-gray-500 ring-gray-200',
    };
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $classes }}">
    {{ ucfirst($status) }}
</span>

