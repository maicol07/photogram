@props([
    'id' => '',
    'menuIcon' => '',
    'title' => '',
    'variants' => ''
])

<header class="mdc-top-app-bar app-bar @empty(!$variants) mdc-top-app-bar--{{$variants}} @endempty">
    <div class="mdc-top-app-bar__row">
        @empty(!$menuIcon)
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                <x-button class="mdc-top-app-bar__navigation-icon" id="{{$id}}" outlined iconButton
                              icon="{{$menuIcon}}" :aria-label="__('Open navigation menu')"/>
                <span class="mdc-top-app-bar__title">{{$title}}</span>
            </section>
        @endempty
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            {{$buttons}}
        </section>
    </div>
</header>
<main class="mdc-top-app-bar--fixed-adjust">
    {{$slot}}
</main>
