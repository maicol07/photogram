@props([
    'text' => ''
])

<li class="mdc-image-list__item">
    <img class="mdc-image-list__image" {{$attributes}}>
    <div class="mdc-image-list__supporting">
        <span class="mdc-image-list__label">{{$text}}</span>
    </div>
</li>
