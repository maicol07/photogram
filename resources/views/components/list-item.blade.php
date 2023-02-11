@props([
    'text' => null,
    'secondaryText' => null,
    'disabled' => false,
    'selected' => false,
    'activated' => false,
    'value' => '',
    'href' => '',
    'ripple' => true,
    'tabindex' => null,
])

@if ($href)
<a href="{{$href}}" role="listitem"
    @else
<li
                @endif
{{$attributes->class([
    'mdc-deprecated-list-item',
    'mdc-deprecated-list-item--disabled' => $disabled,
    'mdc-deprecated-list-item--selected' => $selected,
    'mdc-deprecated-list-item--activated' => $activated
])
        ->merge([
            'aria-disabled' => $disabled ? 'true' : 'false',
            'aria-selected' => $selected ? 'true' : 'false',
            'data-value' => $value,
            'tabindex' => $tabindex
    ])}}
wire:ignore.self>
                @isset($graphic)
                    <span class="mdc-deprecated-list-item__graphic">
                    {!! $graphic !!}
                </span>
                @endisset
                @if($ripple)
                    <span class="mdc-deprecated-list-item__ripple" wire:ignore></span>
                @endif
                <span class="mdc-deprecated-list-item__text" wire:ignore.self>
                    @empty($secondaryText)
                        {{$text ?? $slot}}
                    @else
                        <span class="mdc-deprecated-list-item__primary-text" wire:ignore.self>{{$text ?? $slot}}</span>
                        <span class="mdc-deprecated-list-item__secondary-text"
                              wire:ignore.self>{{$secondaryText}}</span>
                    @endempty
                </span>
                @isset($meta)
                    <span class="mdc-deprecated-list-item__meta" wire:ignore.self>
                {{$meta}}
            </span>
        @endisset
        @if($href)
    </a>
    @else
        </li>
@endif
