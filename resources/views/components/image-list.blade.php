@props([
    'variant' => 'with-text-protection'
])

<ul class="mdc-image-list mdc-image-list--{{$variant}} posts-list">
    {{$slot}}
</ul>
