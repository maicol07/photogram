@props([
    'outlined' => false,
    'textarea' => false,
    'rows' => '8',
    'cols' => '40',
    'maxlength' => null,
    'id' => null,
    'label' => '',
    'name' => null,
    'type' => 'text',
    'value' => '',
    'helperText' => '',
    'error' => '',
    'icon' => ''
])

@php
    $inputId = $id ?? $name ?? Str::random(10);
    $error = $errors->first($inputId) ?? $error;
@endphp

<label wire:ignore.self id="{{$inputId}}" {{$attributes->class([
    'mdc-text-field',
    'mdc-text-field--invalid' => $error,
    'mdc-text-field--outlined' => $outlined,
    'mdc-text-field--filled' => !$outlined,
    'mdc-text-field--textarea' => $textarea,
    'mdc-text-field--textarea--with-internal-counter' => $textarea && $maxlength !== null,
    'mdc-text-field--label-floating' => $value,
    'mdc-text-field--with-leading-icon' => $icon
])}}>
    @if(!$outlined && !$textarea)
        <span class="mdc-floating-label @if($value) mdc-floating-label--float-above @endif" id="{{$inputId}}-label" wire:ignore.self>
            {{$label}}
        </span>
    @else
        <span class="mdc-notched-outline" wire:ignore.self>
            <span class="mdc-notched-outline__leading" wire:ignore></span>
            <span class="mdc-notched-outline__notch" wire:ignore.self>
                <span class="mdc-floating-label @if($value) mdc-floating-label--float-above @endif" id="{{$inputId}}-label" wire:ignore.self>
                    {{$label}}
                </span>
            </span>
            <span class="mdc-notched-outline__trailing" wire:ignore></span>
        </span>
    @endif

    @if($icon)
            <span class="mdi mdi-{{$icon}} mdc-text-field__icon mdc-text-field__icon--leading" aria-hidden="true"></span>
    @endif

    @if($textarea)
        <span class="mdc-text-field__resizer" wire:ignore.self>
            <textarea class="mdc-text-field__input" aria-labelledby="{{$inputId}}-label"
                      id="{{$inputId}}-input"
                      name="{{$name}}"
                      rows="{{$rows}}"
                      cols="{{$cols}}"
                      maxlength="{{$maxlength}}"
                      value="{{$value}}"
                {{$attributes}}></textarea>
            <span class="mdc-text-field-character-counter" wire:ignore>
                {{strlen($value)}} / {{$maxlength}}
            </span>
        </span>
    @else
        <input class="mdc-text-field__input" id="{{$inputId}}-input" name="{{$name}}" type="{{$type}}" aria-labelledby="{{$inputId}}-label" @if($value) value="{{$value}}" @endif @if($maxlength) maxlength="{{$maxlength}}" @endif {{$attributes}} wire:ignore />
    @endif
    @empty($outlined)
        <div class="mdc-line-ripple" wire:ignore></div>
    @endif
</label>

<div class="mdc-text-field-helper-line" wire:ignore.self>
    @if(!$textarea && $maxlength !== null)
        <div class="mdc-text-field-character-counter" wire:ignore>
            {{strlen($value)}} / {{$maxlength}}
        </div>
    @endif
    <div id="{{$inputId}}-helper-text" class="mdc-text-field-helper-text @error($inputId) mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent @enderror" aria-hidden="true">
        @empty($error)
            {{$helperText}}
        @else
            {{$error}}
        @endempty
    </div>
</div>
