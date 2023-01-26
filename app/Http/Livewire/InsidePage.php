<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Spatie\Navigation\Navigation;

abstract class InsidePage extends Page
{
    public function getNavigation(): array
    {
        return [
            'Home' => ['routeName' => 'inside.home', 'icon' => 'home'],
            'Profile' => ['routeName' => 'inside.profile', 'icon' => 'account'],
            //'Settings' => route(''),
        ];
    }

    public function render(): View
    {
        return $this->page()->extends('layouts.inside', ['navigation' => $this->getNavigation()])->section('main');
    }
}
