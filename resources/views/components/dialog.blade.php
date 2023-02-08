@props([
    'title' => '',
    'id' => 'id-dialog',
])

<div class="mdc-dialog" wire:ignore.self id="{{$id}}" {{$attributes}}>
    <div class="mdc-dialog__container" wire:ignore.self>
        <div class="mdc-dialog__surface"
             role="alertdialog"
             aria-modal="true"
             aria-labelledby="{{$id.'-title'}}"
             aria-describedby="{{$id.'-content'}}" wire:ignore.self>
            <h2 class="mdc-dialog__title" id="{{$id.'-title'}}" wire:ignore.self>{{$title}}</h2>
            <div class="mdc-dialog__content" id="{{$id.'-content'}}" wire:ignore.self>
                {{$slot}}
            </div>
        </div>
    </div>
    <div class="mdc-dialog__scrim" wire:ignore.self></div>
</div>
