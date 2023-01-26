@props([
    'text' => '',
    'secondaryText' => '',
    'disabled' => false,
    'selected' => false,
    'value' => '',
    'href' => '',
    'ripple' => true,
])

<li {{$attributes->class([
    'mdc-deprecated-list-item',
    'mdc-deprecated-list-item--disabled' => $disabled,
    'mdc-deprecated-list-item--selected' => $selected,
])
        ->merge([
            'aria-disabled' => $disabled,
            'aria-selected' => $selected,
            'data-value' => $value,
    ])}}
    wire:ignore.self>
    @if ($href)
        <a href="{{$href}}">
    @endif
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
                    @empty($text)
                        {{$slot}}
                    @else
                        {{$text}}
                    @endempty
                @else
                    <span class="mdc-deprecated-list-item__primary-text" wire:ignore.self>
                    @empty($text)
                            {{$slot}}
                        @else
                            {{$text}}
                        @endempty
                </span>
                    <span class="mdc-deprecated-list-item__secondary-text" wire:ignore.self>{{$secondaryText}}</span>
                @endempty
        </span>
            @isset($meta)
                <span class="mdc-deprecated-list-item__meta" wire:ignore.self>
                {{$meta}}
            </span>
        @endisset
            @if($href)
        </a>
    @endif
</li>
