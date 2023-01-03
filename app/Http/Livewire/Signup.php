<?php

namespace App\Http\Livewire;
use Illuminate\Contracts\View\View;

use Livewire\Component;

class Signup extends Page
{
    public string $name='';
    public string $surname='';
    public string $email='';
    public string $dateOfBirth = '';
    public string $username='';
    public string $password='';
    public string $repeatPassword='';

    public $rules = [
        'name' => 'required|string',
        'surname' => 'required|string',
        'email' => 'required|string|unique:App\Models\User,email',
        'dateOfBirth' => 'required|date',
        'username' => 'required|max:20|min:4|string|unique:App\Models\User,username',
        'password' => 'required|max:24|min:8|string',
    ];

    public function signup(): void
    {
        $validatedData = $this->validate(attributes: [
            "username" => "Username",
            "password" => "Password",
            "name" => "Name",
            "surname" => "Surname",
            "email" => "Email",
            "dateOfBirth" => "Date of birth"
        ]);



    }

    public function page(): View
    {
        return view('livewire.signup');
    }
}
