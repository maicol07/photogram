<x-select outlined id="language"
          label="{{__('Language')}}"
          :options="$this->getLanguages()"
          :value="$this->locale"
          wire:model="locale"
/>
