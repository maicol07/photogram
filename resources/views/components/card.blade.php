@props([
    'variant' => 'outlined',
])

<div {{$attributes->class(['mdc-card', "mdc-card--$variant"])->merge()}}>
    {{$slot}}
</div>
