<?php

namespace App\Http\Livewire\Traits;

trait MDCMenuSurfaceFeatures
{
    use MDCFeatures;

    /**
     * Opens a menu with the given action ID
     */
    public function openMenuSurface(string $id, ?string $message = null, ?string $openAction = null): void
    {
        $this->openCloseComponent($id, 'MDCMenuSurface', true, $openAction, $message);
    }

    /**
     * Closes a menu with the given action ID
     */
    public function closeMenuSurface(string $id, ?string $closeAction = null): void
    {
        $this->openCloseComponent($id, 'MDCMenuSurface', false, $closeAction);
    }
}
