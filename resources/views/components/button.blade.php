@props([
    'dialogButton' => false,
    'type' => 'button',
    'outlined' => false,
    'label' => '',
    'variant' => 'text', // Can be raised, outlined, text
    'icon' => '', // MDI icon (reference: https://materialdesignicons.com)
    'trailingIcon' => false,
])

@php($tag = $attributes->get('href') ? 'a' : 'button')

<div class="mdc-touch-target-wrapper">
    @if($tag === 'a')
        <a
    @else
        <button
    @endif
      class="mdc-button @if($variant !== 'text') mdc-button--{{$variant}} @endif
        @if($dialogButton) mdc-dialog__button @endif" {{$attributes}} wire:ignore.self>
        <span class="mdc-button__ripple" wire:ignore></span>
        <span class="mdc-button__touch" wire:ignore></span>
        <span class="mdc-button__focus-ring" wire:ignore></span>

        @if($icon && !$trailingIcon)
            <i class="mdi mdi-{{$icon}} mdc-button__icon" aria-hidden="true"></i>
        @endif

        <span class="mdc-button__label" wire:ignore.self>{{$label}}</span>

        @if($icon && $trailingIcon)
            <i class="mdi mdi-{{$icon}} mdc-button__icon" aria-hidden="true"></i>
        @endif
    @if($tag === 'button')
        </button>
    @else
        </a>
    @endif
</div>
