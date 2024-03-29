<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;

abstract class InsidePage extends Page
{
    public function getNavigation(): array
    {
        return [
            __('Home') => ['routeName' => 'inside.home', 'icon' => 'home'],
            __('Profile') => ['routeName' => 'inside.profile', 'icon' => 'account'],
            __('Settings') => ['routeName' => 'inside.settings', 'icon' => 'cog-outline'],
        ];
    }


    public function render(): View
    {
        return (parent::render())->extends('layouts.inside', ['navigation' => $this->getNavigation(), 'title' => $this->getTitle()])->section('main');
    }
}
