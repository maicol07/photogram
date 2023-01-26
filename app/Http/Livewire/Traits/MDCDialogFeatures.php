<?php

namespace App\Http\Livewire\Traits;

trait MDCDialogFeatures
{
    use MDCFeatures;

    /**
     * Opens a dialog with the given action ID
     */
    public function openDialog(string $id, ?string $openAction = null): void
    {
        $this->openCloseComponent($id, 'MDCDialog', true, $openAction);
    }

    /**
     * Closes a dialog with the given action ID
     */
    public function closeDialog(string $id, ?string $closeAction = null): void
    {
        $this->openCloseComponent($id, 'MDCDialog', false, $closeAction);
    }
}
