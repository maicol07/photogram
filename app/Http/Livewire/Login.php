<?php

namespace App\Http\Livewire;

use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;
use Request;

class Login extends Page
{
    public string $username = '';
    public string $password = '';

    public $rules = [
        'username' => 'required|max:20|string',
        'password' => 'required|min:8|string',
    ];

    public function login(): void
    {
        //$credentials = ['username' => $this->username, 'password' => $this->password];

        $validatedData = $this->validate(attributes: [
            "username" => "Username",
            "password" => "Password"
        ]);


        if (Auth::attempt($validatedData)) {
            dd('if true');
            session()->regenerate();
//            return redirect()->intended('dashboard');
        }
        session()->flash('message', 'The provided credentials do not match our records.');
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName, attributes: [
            "username" => "Username",
            "password" => "Password"
        ]);
    }

    public function page(): View
    {
        return view('livewire.login');
    }
}
