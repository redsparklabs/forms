 @props([
    'text' => null
])

 <button {{ $attributes->merge() }} class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-yellow-500 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-800 cursor-pointer">
    {{ $text ?? $slot }}
</button>
