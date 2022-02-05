@props([
    'dir',
    'active' => false
])
@if($active)
    @if($dir == 'desc')
        <i class="gg-sort-az inline-block ml-2 mb-1"></i>
    @else
        <i class="gg-sort-za inline-block ml-2 mb-1"></i>
    @endif
@endif
