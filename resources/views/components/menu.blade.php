@props([
    'anchorId' => null,
    'fixed' => false,
])

<x-menu-surface class="mdc-menu" wire:ignore.self {{$attributes}} :data-fixed="$fixed"  :data-anchorId="$anchorId">
    {{$slot}}
</x-menu-surface>
