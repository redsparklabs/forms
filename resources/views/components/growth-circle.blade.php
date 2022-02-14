@props([
    $metric,
    $color
])
@php
@dd($color);
    $circumference = 2 * 22 / 7 * 120
@endphp
<div class="flex items-center justify-center">
    <svg class="transform -rotate-90 w-72 h-72">
        <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="30" fill="transparent" class="text-gray-100" />

        <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="30" fill="transparent"
            stroke-dasharray="{{ $circumference }}"
            stroke-dashoffset="{{ $circumference - ( (float) $metric * 20) / 100 * $circumference }}"
            class="text-{{ $color}}" />
    </svg>
    <div class="flex items-center justify-center absolute text-5xl bg-{{ $color }} text-white rounded-full w-32 h-32 text-center p-4">{{ number_format((float) $metric, 1) }}</div>
</div>
