<x-list id="languages-list" class="language-list" role="menu" aria-hidden="true" aria-orientation="vertical"
        tabindex="-1">
    @foreach($this->getLanguages() as $val => $details)
        @php
            //                    $first = reset($options) === $details;
                                $label = $details['label'] ?? (is_string($details) ? $details : '');
                                $graphic = $details['graphic'] ?? '';
                                $disabled = $details['disabled'] ?? false;
                                $selected = $details['selected'] ?? ($val === $this->locale)
        @endphp
        <x-list-item :selected="$selected"
                     :disabled="$disabled"
                     :value="$val"
                     :text="$label"
                     role="menuitem"
                     wire:ignore.self>
            <x-slot:graphic>
                {!! $graphic !!}
            </x-slot:graphic>
        </x-list-item>
    @endforeach
</x-list>
