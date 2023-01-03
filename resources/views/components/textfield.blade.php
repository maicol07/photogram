@props([
    'outlined' => false,
    'textarea' => false,
    'rows' => '8',
    'cols' => '40',
    'maxlength' => '140',
    'id' => '',
    'label' => '',
    'type' => 'text',
    'value' => ''
])

<label wire:ignore.self class="mdc-text-field mdc-text-field--{{$outlined ? 'outlined' : 'filled'}}
    @if($textarea) mdc-text-field--textarea mdc-text-field--with-internal-counter @endif
    @if($value) mdc-text-field--label-floating @endif">
    @if(!$outlined && !$textarea)
        <span class="mdc-floating-label" id="{{$id}}-label" wire:ignore.self>{{$label}}</span>
    @else
        <span class="mdc-notched-outline" wire:ignore.self>
            <span class="mdc-notched-outline__leading" wire:ignore></span>
            <span class="mdc-notched-outline__notch" wire:ignore.self>
                <span class="mdc-floating-label @if($value) mdc-floating-label--float-above @endif" id="{{$id}}-label" wire:ignore.self>
                    {{$label}}
                </span>
            </span>
            <span class="mdc-notched-outline__trailing" wire:ignore></span>
        </span>
    @endif

    @if($textarea)
        <span class="mdc-text-field__resizer" wire:ignore.self>
            <textarea class="mdc-text-field__input" aria-labelledby="{{$id}}-label"
                      rows="{{$rows}}"
                      cols="{{$cols}}"
                      maxlength="{{$maxlength}}"
                      value="{{$value}}"
                {{$attributes}}></textarea>
            <span class="mdc-text-field-character-counter" wire:ignore.self>0 / {{$maxlength}}</span>
        </span>
    @else
        <input class="mdc-text-field__input" type="{{$type}}" aria-labelledby="{{$id}}-label" value="{{$value}}" {{$attributes}} wire:ignore />
    @endif
    @empty($outlined)
        <div class="mdc-line-ripple" wire:ignore></div>
    @endif
</label>
