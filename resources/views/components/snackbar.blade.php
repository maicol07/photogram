@props([
    'open' => false, //
    'id' => '',
    'message'=> '',
])

<aside id="{{$id}}" class="mdc-snackbar" {{$attributes}} wire:ignore @if($open) data-open @endif>
    <div class="mdc-snackbar__surface" role="status" aria-relevant="additions">
        <div class="mdc-snackbar__label" aria-atomic="false">
            {{$message}}
        </div>
    </div>
</aside>
