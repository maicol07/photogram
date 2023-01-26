@props([
    'variants' => '',
    'mainClass' => '',
])

<div class="drawer">
    <aside class="mdc-drawer mdc-drawer--@if($variants){{$variants}}@endif">
        <div class="mdc-drawer__content">
            <nav class="mdc-deprecated-list">
                {{$icons}}
            </nav>
        </div>
    </aside>
    @if($mainClass)
        <div class="mdc-drawer-{{$mainClass}}">
            {{$slot}}
        </div>
    @endif
</div>
