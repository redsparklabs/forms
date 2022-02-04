@props([
    'background' => true
])
<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-5 md:gap-6']) }}>
    <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title>

    <div class="mt-5 md:mt-0 md:col-span-4">
        <div @class([
            'px-4 py-5 sm:p-6 sm:rounded-lg bg-white shadow' => $background
        ])>
            {{ $content }}
        </div>
    </div>
</div>
