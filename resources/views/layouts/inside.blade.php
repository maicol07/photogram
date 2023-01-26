@extends('layouts.app')

@section('content')
    <x-drawer variants="dismissible" mainClass="app-content">
        <x-slot:icons>
            @foreach($navigation as $keyNav => $buttonNav)
                <a href="{{route($buttonNav['routeName'])}}" class="mdc-deprecated-list-item
                @if(Route::currentRouteName() === $buttonNav['routeName']) mdc-deprecated-list-item--activated @endif" aria-current="page">
                    <span class="mdc-deprecated-list-item__ripple"></span>
                    <i class="mdi mdi-{{$buttonNav['icon']}} mdc-deprecated-list-item__graphic icon-drawer" aria-hidden="true"></i>
                    <span class="mdc-deprecated-list-item__text">{{$keyNav}}</span>
                </a>
            @endforeach
        </x-slot:icons>
        <x-top-app-bar menu-icon="menu" title="Photogram" id="menu-top-app-bar">
            <x-slot:buttons>
                <livewire:ui.post.new-post-button />
                <x-button class="mdc-top-app-bar__action-item" id="search-top-app-bar" outlined iconButton icon="magnify"/>
                <livewire:ui.user.notification/>
                <livewire:ui.language.menu/>
                <livewire:ui.user.top-app-bar-user-icon/>
            </x-slot:buttons>
            @yield('main')
        </x-top-app-bar>
    </x-drawer>
@endsection