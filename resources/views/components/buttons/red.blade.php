 @props([
    'text' => null
])

 <button {{ $attributes->merge() }} class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-karban-red hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
    {{ $text ?? $slot }}
</button>
