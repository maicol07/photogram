<?php

namespace App\Http\Livewire;

use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;

class Login extends Page
{
    public bool $remember = false;
    public string $username = '';
    public string $password = '';

    public $rules = [
        'username' => 'required|max:20|string',
        'password' => 'required|min:8|string',
    ];

    public function login(): void
    {

        $validatedData = $this->validate(attributes: [
            "username" => "Username",
            "password" => "Password",
        ]);


        if (Auth::attempt($validatedData, $this->remember)) {
            session()->regenerate();
//            return redirect()->intended('dashboard');
        }
        session()->flash('message', __('The provided credentials do not match our records.'));
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, attributes: [
            "username" => "Username",
            "password" => "Password",
        ]);
    }

    public function page(): View
    {
        return view('livewire.login');
    }

    public function goToSignup(): RedirectResponse|Redirector
    {
        return redirect()->route('signup');
    }
}
