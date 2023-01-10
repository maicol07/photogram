@props([
    'label'=>'',
    'id'=> '',
])
<div class="mdc-form-field" wire:ignore.self>
    <div class="mdc-touch-target-wrapper" wire:ignore.self>
        <div class="mdc-checkbox mdc-checkbox--touch" wire:ignore.self {{$attributes}}>
            <input type="checkbox"
                   class="mdc-checkbox__native-control"
                   id="{{$id}}" {{$attributes->only('wire:model')}} wire:ignore/>
            <div class="mdc-checkbox__background" wire:ignore>
                <svg class="mdc-checkbox__checkmark"
                     viewBox="0 0 24 24">
                    <path class="mdc-checkbox__checkmark-path"
                          fill="none"
                          d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                </svg>
                <div class="mdc-checkbox__mixedmark"></div>
            </div>
            <div class="mdc-checkbox__ripple" wire:ignore></div>
            <div class="mdc-checkbox__focus-ring" wire:ignore></div>
        </div>
    </div>
    <label for="{{$id}}" wire:ignore.self>{{$label}}</label>
</div>
