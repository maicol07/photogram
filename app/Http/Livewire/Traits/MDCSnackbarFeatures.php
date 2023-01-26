<?php

namespace App\Http\Livewire\Traits;

trait MDCSnackbarFeatures
{
    use MDCFeatures;

    /**
     * Opens a snackbar with the given action ID
     */
    public function openSnackbar(string $id, ?string $message = null, ?string $openAction = null): void
    {
        $this->openCloseComponent($id, 'MDCSnackbar', true, $openAction, $message);
    }

    /**
     * Closes a snackbar with the given action ID
     */
    public function closeSnackbar(string $id, ?string $closeAction = null): void
    {
        $this->openCloseComponent($id, 'MDCSnackbar', false, $closeAction);
    }
}
