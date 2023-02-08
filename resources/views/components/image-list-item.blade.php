@props([
    'text' => '',
    'src' => '',
    'alt' => ''
])

<li {{$attributes->class('mdc-image-list__item')}}>
    <img class="mdc-image-list__image" src="{{$src}}" alt="{{$alt}}">
    <div class="mdc-image-list__supporting">
        <span class="mdc-image-list__label">{{$text}}</span>
    </div>
</li>
