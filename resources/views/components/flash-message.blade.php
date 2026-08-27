@props(['type' => 'success', 'message' => null])

@php
    $types = [
        'success' => ['bg' => 'bg-emerald-50 border-emerald-200', 'text' => 'text-emerald-800', 'icon' => 'text-emerald-500'],
        'error'   => ['bg' => 'bg-red-50 border-red-200',     'text' => 'text-red-800',     'icon' => 'text-red-500'],
        'warning' => ['bg' => 'bg-amber-50 border-amber-200', 'text' => 'text-amber-800',   'icon' => 'text-amber-500'],
        'info'    => ['bg' => 'bg-blue-50 border-blue-200',   'text' => 'text-blue-800',    'icon' => 'text-blue-500'],
    ];
    $style = $types[$type] ?? $types['info'];
@endphp

@if ($message || session($type) || session('success') || session('error'))
    @php
        $msg = $message ?? session($type) ?? session('success') ?? session('error');
        $resolvedType = $message ? $type : (session('success') ? 'success' : (session('error') ? 'error' : $type));
        $resolvedStyle = $types[$resolvedType] ?? $types['info'];
    @endphp
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        x-init="setTimeout(() => show = false, 5000)"
        class="mb-4 flex items-start gap-3 rounded-lg border px-4 py-3 {{ $resolvedStyle['bg'] }}"
        role="alert"
    >
        <svg class="mt-0.5 h-5 w-5 flex-shrink-0 {{ $resolvedStyle['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            @if ($resolvedType === 'success')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            @elseif ($resolvedType === 'error')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            @elseif ($resolvedType === 'warning')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            @else
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            @endif
        </svg>
        <p class="text-sm font-medium {{ $resolvedStyle['text'] }}">{{ $msg }}</p>
        <button @click="show = false" class="ml-auto -mr-1 rounded p-1 hover:bg-black/5 {{ $resolvedStyle['icon'] }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

