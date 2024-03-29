@props([
    'type' => 'button',
    'iconButton' => false,
    'dialogButton' => false,
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
        <button type="{{$type}}"
    @endif
      {{$attributes->class([
    'mdc-button' => !$iconButton,
    'mdc-icon-button' => $iconButton,
    'mdc-button--raised' => $variant === 'raised',
    'mdc-button--outlined' => $variant === 'outlined',
    'mdc-dialog__button' => $dialogButton
])}} wire:ignore.self>
        <span class="mdc-{{$iconButton ? 'icon-button__ripple' : 'button__ripple'}}" wire:ignore></span>
        @if(!$iconButton)
            <span class="mdc-button__touch" wire:ignore></span>
        @endif
        <span class="mdc-{{$iconButton ? 'icon-button__focus-ring' : 'button__focus-ring'}}" wire:ignore></span>

        @if($icon && !$trailingIcon)
            <span class="mdi mdi-{{$icon}} mdc-button__icon" aria-hidden="true"></span>
        @endif

        @if(!$iconButton)
            <span class="mdc-button__label" wire:ignore.self>{{$label}}</span>
        @endif

        @isset($image)
            {{$image}}
        @endisset

        @if($icon && $trailingIcon)
            <span class="mdi mdi-{{$icon}} {{$iconButton ? 'mdc-icon-button__icon' : 'mdc-button__icon' }}" aria-hidden="true"></span>
        @endif

        @if($iconButton)
            <div class="mdc-icon-button__touch"></div>
        @endif
    @if($tag === 'button')
        </button>
    @else
        </a>
    @endif
</div>
