<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/scss/app.scss')
    <title>PhotoGram</title>
    @livewireStyles
</head>
<body>
@yield('content')

@livewireScripts
@vite('resources/js/app.js')
</body>
</html>
