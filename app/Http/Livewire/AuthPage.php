<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Spatie\Navigation\Navigation;

abstract class AuthPage extends Page
{
    public function render(): View
    {
        return (parent::render())->extends('layouts.auth', ['title' => $this->getTitle()])->section('main');
    }

    public function validationAttributes(): array
    {
        return [
            "username" => __("Username"),
            "password" => __("Password"),
            "name" => __("Name"),
            "surname" => __("Surname"),
            "email" => __("Email"),
            "password_confirmation" => __("Password confirmation"),
        ];
    }
}
