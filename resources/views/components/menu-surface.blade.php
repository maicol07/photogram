@props([
    'anchorId' => null,
    'fixed' => false,
])

<div {{$attributes->merge(['class' => 'mdc-menu-surface'])}} wire:ignore.self @if($fixed) data-fixed="{{$fixed}}" @endif @if($anchorId) data-anchorId="{{$anchorId}}" @endif >
    {{$slot}}
</div>
