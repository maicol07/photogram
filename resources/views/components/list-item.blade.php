@props([
    'text' => null,
    'secondaryText' => null,
    'disabled' => false,
    'selected' => false,
    'activated' => false,
    'value' => '',
    'href' => '',
    'ripple' => true,
    'role' => null,
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
            'aria-disabled' => $role === 'option' ? ($disabled ? 'true' : 'false') : null,
            'aria-selected' => $role === 'option' ? ($selected ? 'true' : 'false') : null,
            'data-value' => $value,
            'tabindex' => $tabindex,
            'role' => $role
    ])}}
wire:ignore.self>
                @isset($graphic)
                    @if($graphic->attributes->has('href'))
                        <a href="{{$graphic->attributes->get('href')}}" class="mdc-deprecated-list-item__graphic"
                           wire:ignore.self>
                            {!! $graphic !!}
                        </a>
                    @else
                        <span class="mdc-deprecated-list-item__graphic">
                            {!! $graphic !!}
                        </span>
                    @endif
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
