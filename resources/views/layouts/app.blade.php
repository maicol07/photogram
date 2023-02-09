<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/scss/app.scss')
    <title>PhotoGram</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8"/>
    @livewireStyles
</head>
<body>
@isset($slot)
    {{ $slot }}
@else
    @yield('content')
@endisset

@if(session()->has('message'))
    <x-snackbar id="message-snackbar" :message="session()->pull('message', '')"/>
@endif
@livewireScripts
@vite('resources/js/app.js')
</body>
</html>
