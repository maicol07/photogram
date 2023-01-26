@extends('layouts.app')

<div class="auth-container">
    <div class="mdc-card mdc-card--outlined auth-card" >
        @yield('main')
    </div>
    @stack('bottom')
    <livewire:ui.language.select style="margin-top: 16px;"/>
</div>
