 @props([
    'text' => null
])

 <button {{ $attributes->merge() }} class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-karban-green-1 hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-700 cursor-pointer">
    {{ $text ?? $slot }}
</button>
