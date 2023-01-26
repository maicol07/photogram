<?php

namespace App\Http\Livewire\Traits;

trait MDCMenuFeatures
{
    use MDCFeatures;

    /**
     * Opens a menu with the given action ID
     */
    public function openMenu(string $id, ?string $openAction = null): void
    {
        $this->openCloseComponent($id, 'MDCMenu', true, $openAction);
    }

    /**
     * Closes a menu with the given action ID
     */
    public function closeMenu(string $id, ?string $closeAction = null): void
    {
        $this->openCloseComponent($id, 'MDCMenu', false, $closeAction);
    }
}
