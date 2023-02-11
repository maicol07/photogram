@extends('layouts.app')

@section('content')
    <div class="auth-container">
        <h1>{{$title}}</h1>
        <div class="mdc-card mdc-card--outlined container-card" >
            @yield('main')
        </div>
        @stack('bottom')
        <livewire:ui.language.select style="margin-top: 16px;"/>
    </div>
@endsection
