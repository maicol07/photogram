@props([
    'variant' => 'outlined',
])

<div class="mdc-card @if($variant !== null) mdc-card--{{$variant}} @endif" {{$attributes}}>
    {{$slot}}
</div>
