@extends('layouts.app')

@section('content')
    <x-drawer variants="dismissible" mainClass="app-content">
        <x-slot:icons>
            @foreach($navigation as $keyNav => $buttonNav)
                @php($isCurrentRoute = Route::currentRouteName() === $buttonNav['routeName'])
                <x-list-item :href="route($buttonNav['routeName'])" :activated="$isCurrentRoute" :aria-current="$isCurrentRoute ? 'page' : null">
                    <x-slot:graphic>
                        <span class="mdi mdi-{{$buttonNav['icon']}}" aria-hidden="true"></span>
                    </x-slot:graphic>
                    {{$keyNav}}
                </x-list-item>
            @endforeach
        </x-slot:icons>
        <x-top-app-bar menu-icon="menu" title="Photogram" id="menu-top-app-bar">
            <x-slot:buttons>
                <x-button class="mdc-top-app-bar__action-item" id="new-post-top-app-bar" outlined iconButton icon="plus"
                          :href="route('inside.newPost')" :aria-label="__('New post button')"/>
                <livewire:ui.user.search/>
                <livewire:ui.user.notification/>
                <livewire:ui.language.menu/>
                <livewire:ui.user.top-app-bar-user-icon/>
            </x-slot:buttons>
            @if ($title)
                <h2 id="page-title">{{$title}}</h2>
            @endif

            @yield('main')
        </x-top-app-bar>
    </x-drawer>
@endsection
