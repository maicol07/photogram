<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\AuthPage;
use App\Http\Livewire\Traits\MDCSnackbarFeatures;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;

class Login extends AuthPage
{
    use MDCSnackbarFeatures;

    public bool $remember = false;
    public string $username = '';
    public string $password = '';

    public $rules = [
        'username' => 'required|max:20|string',
        'password' => 'required|min:8|string',
    ];

    public function authGoogle(): void
    {
        session()->put('from', 'login');
        $this->redirectRoute('auth.redirect-provider', ['provider' => 'google']);
    }

    public function login(): RedirectResponse|Redirector|null
    {
        $validatedData = $this->validate();

        if (Auth::attempt($validatedData, $this->remember)) {
            session()->regenerate();
            $this->openSnackbar('loginMessage', __('Authentication successful.'));

            return redirect()->route('inside.home');
        }

        $this->openSnackbar(
            'loginMessage',
            __('The provided credentials do not match our records.'),
            'loginFailed'
        );
        return null;
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function page(): View
    {
        return view('livewire.auth.login');
    }


    /**
     * @param string $message
     * @return Login
     */
    public function setMessage(string $message): Login
    {
        $this->message = $message;
        return $this;
    }

    public function getTitle(): string
    {
        return __('Login');
    }
}
