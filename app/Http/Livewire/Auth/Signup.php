<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\AuthPage;
use App\Http\Livewire\Traits\MDCSnackbarFeatures;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

class Signup extends AuthPage
{
    use MDCSnackbarFeatures;

    public string $name = '';
    public string $surname = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';
    public string $password_confirmation = '';

    public $rules = [
        'name' => 'required|string',
        'surname' => 'required|string',
        'email' => 'required|email|unique:App\Models\User,email',
        'username' => 'required|max:20|min:4|string|unique:App\Models\User,username',
        'password' => 'required|max:24|min:8|string',
        'password_confirmation' => 'required|same:password',
    ];

    public function authGoogle(): void
    {
        session()->put('from', 'signup');
        $this->redirectRoute('auth.redirect-provider', ['provider' => 'google']);
    }

    public function signup(): void
    {
        $validatedData = $this->validate(attributes: [
            "username" => __("Username"),
            "password" => __("Password"),
            "name" => __("Name"),
            "surname" => __("Surname"),
            "email" => __("Email"),
            "repeatPassword" => __("Repeated Password"),
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->surname = $validatedData['surname'];
        $user->email = $validatedData['email'];
        $user->username = $validatedData['username'];
        $user->password = Hash::make($validatedData['password']);
        $user->profileImage = null;
        $user->bio = null;
        $user->save();

        event(new Registered($user));
        auth()->login($user);

        $this->openSnackbar('signupMessage', __('Registration completed successfully.'), 'signupSuccess');
        redirect()->route('inside.home');
    }

    public function page(): View
    {
        return view('livewire.auth.signup');
    }

    public function goToLogin(): RedirectResponse|Redirector
    {
        return redirect()->route('login');
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, attributes: [
            "username" => __("Username"),
            "password" => __("Password"),
            "name" => __("Name"),
            "surname" => __("Surname"),
            "email" => __("Email"),
            "dateOfBirth" => __("Date of birth"),
            "repeatPassword" => __("Repeated Password"),
        ]);
    }
}
