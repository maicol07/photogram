<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;

abstract class InsidePage extends Page
{
    public function getNavigation(): array
    {
        return [
            'Home' => ['routeName' => 'inside.home', 'icon' => 'home'],
            'Profile' => ['routeName' => 'inside.profile', 'icon' => 'account'],
            'Settings' => ['routeName' => 'inside.settings', 'icon' => 'cog-outline'],
        ];
    }

    public function getTitle(): string
    {
        return '';
    }

    public function render(): View
    {
        return $this->page()->extends('layouts.inside', ['navigation' => $this->getNavigation(), 'title' => $this->getTitle()])->section('main');
    }
}
