@props([
    'textual_list' => false,
    'avatar_list' => false,
    'icon_list' => false,
    'image_list' => false,
    'thumbnail_list' => false,
    'video_list' => false,
    'two_line' => false,
    'options' => [],
    'role' => null // Can be 'listbox' for select lists or 'menu' for lists inside menus (Default value is 'list')
])

<ul {{$attributes->class([
    'mdc-deprecated-list',
    'mdc-deprecated-list--two-line' => $two_line
])->merge([
    'role' => $role
])}}>
    @isset($slot)
        {{$slot}}
    @else
        @foreach($options as $val => $details)
            @php
                $first = reset($options) === $details;
                $label = $details['label'] ?? (is_string($details) ? $details : '');
                $graphic = $details['graphic'] ?? '';
                $disabled = $details['disabled'] ?? false;
                $selected = $details['selected'] ?? ($val === $value);
                $role = $details['role'] ?? ($role === 'listbox' ? 'option' : null);
            @endphp
            <x-list-item :selected="$selected"
                         :disabled="$disabled"
                         :value="$val"
                         :text="$label"
                         :role="$role"
                         :tabindex="($first || $selected) ? 0 : null" wire:ignore.self>
                <x-slot:graphic>
                    {!! $graphic !!}
                </x-slot:graphic>
            </x-list-item>
        @endforeach
    @endisset
</ul>
