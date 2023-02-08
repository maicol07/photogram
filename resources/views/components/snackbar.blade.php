@props([
    'id' => '',
    'message'=> '',
    'timeout' => 5000,
    'withAction' => false,
    'actionText' => __('OK')
])

<aside id="{{$id}}" class="mdc-snackbar" {{$attributes}} data-timeout="{{$timeout}}">
    <div class="mdc-snackbar__surface" role="status" aria-relevant="additions">
        <div class="mdc-snackbar__label" aria-atomic="false">
            {{$message}}
        </div>

        @if($withAction || $timeout === -1)
            <div class="mdc-snackbar__actions" aria-atomic="true">
                <x-button type="button" class="mdc-button mdc-snackbar__action" :label="$actionText"></x-button>
            </div>
        @endif
    </div>
</aside>
