<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

class Signup extends Page
{
    public string $name = '';
    public string $surname = '';
    public string $email = '';
    public string $dateOfBirth = '';
    public string $username = '';
    public string $password = '';
    public string $repeatPassword = '';

    public $rules = [
        'name' => 'required|string',
        'surname' => 'required|string',
        'email' => 'required|string|unique:App\Models\User,email',
        'dateOfBirth' => 'required|date',
        'username' => 'required|max:20|min:4|string|unique:App\Models\User,username',
        'password' => 'required|max:24|min:8|string',
        'repeat-password' => 'required|same:password',
    ];

    public function signup(): void
    {
        $validatedData = $this->validate(attributes: [
            "username" => __("Username"),
            "password" => __("Password"),
            "name" => __("Name"),
            "surname" => __("Surname"),
            "email" => __("Email"),
            "dateOfBirth" => __("Date of birth"),
            "repeat-password" => __("Repeated Password"),
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->surname = $validatedData['surname'];
        $user->email = $validatedData['email'];
        $user->username = $validatedData['username'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();
    }

    public function page(): View
    {
        return view('livewire.signup');
    }

    public function goToLogin(): RedirectResponse|Redirector
    {
        return redirect()->route('login');
    }
}
