@props([
    'outlined' => false,
    'label' => null,
    'id' => '',
    'ariaLabel' => null,
    'options' => [],
    'blankOption' => false,
    'value' => ''
])

<div wire:ignore.self id="{{$id}}" class="mdc-select mdc-select--{{$outlined ? 'outlined' : 'filled'}}" {{$attributes}}>
    <input type="hidden" name="{{$id}}" {{$attributes->only('wire:model')}} value="{{$value}}" wire:ignore/>
    <div class="mdc-select__anchor"
         role="button"
         aria-haspopup="listbox"
         aria-expanded="false"
         aria-labelledby="{{$id}}-label {{$id}}-selected-text" wire:ignore.self>
        @if($outlined)
            <span class="mdc-notched-outline" wire:ignore.self>
                <span class="mdc-notched-outline__leading" wire:ignore></span>
                <span class="mdc-notched-outline__notch" wire:ignore.self>
                    <span id="{{$id}}-label" class="mdc-floating-label" wire:ignore.self>
                        {{$label}}
                    </span>
                </span>
              <span class="mdc-notched-outline__trailing" wire:ignore.self></span>
            </span>
        @else
            <span class="mdc-select__ripple" wire:ignore></span>
            <span id="{{$id}}-label" class="mdc-floating-label" wire:ignore.self>{{$label}}</span>
        @endif

        <span class="mdc-select__selected-text-container" wire:ignore.self>
          <span id="{{$id}}-selected-text" class="mdc-select__selected-text" wire:ignore.self>
              @if($value)
                  {{$options[$value]['label'] ?? (is_string($options[$value]) ? $options[$value] : '')}}
              @endif
          </span>
        </span>

        <span class="mdc-select__dropdown-icon" wire:ignore>
            <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5" focusable="false">
                <polygon class="mdc-select__dropdown-icon-inactive"
                         stroke="none"
                         fill-rule="evenodd"
                         points="7 10 12 15 17 10"></polygon>
                <polygon class="mdc-select__dropdown-icon-active"
                         stroke="none"
                         fill-rule="evenodd"
                         points="7 15 12 10 17 15"></polygon>
            </svg>
        </span>

        @if(!$outlined)
            <span class="mdc-line-ripple" wire:ignore></span>
        @endif
    </div>

    <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth" wire:ignore.self>
        <x-list role="listbox" aria-label="{{$ariaLabel ?? $label}}" wire:ignore.self>
            @if($blankOption)
                <x-list-item :selected="(bool) $value" :value="''" wire:ignore.self role="option">
                    <span class="mdc-deprecated-list-item__ripple"></span>
                </x-list-item>
            @endif
            @foreach($options as $val => $details)
                @php
                    $first = reset($options) === $details;
                    $label = $details['label'] ?? (is_string($details) ? $details : '');
                    $graphic = $details['graphic'] ?? '';
                    $disabled = $details['disabled'] ?? false;
                    $selected = $details['selected'] ?? ($val === $value);
                @endphp
                <x-list-item :selected="$selected"
                    :disabled="$disabled"
                    :value="$val"
                    :text="$label"
                    role="option"
                    :tabindex="$first ? 0 : null" wire:ignore.self>
                    <x-slot:graphic>
                        {!! $graphic !!}
                    </x-slot:graphic>
                </x-list-item>
            @endforeach
        </x-list>
    </div>
</div>
