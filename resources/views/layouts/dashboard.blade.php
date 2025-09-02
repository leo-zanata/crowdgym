<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Crowd Gym</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @yield('css-files')

    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png" sizes="32x32" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    @yield('links')
</head>

<body>
    @auth
        @if (Auth::user()->type === 'admin')
            @include('partials.admin.header')
        @elseif (Auth::user()->type === 'manager')
            @include('partials.manager.header')
        @elseif (Auth::user()->type === 'employee')
            @include('partials.employee.header')
        @elseif (Auth::user()->type === 'member')
            @include('partials.member.header')
        @endif
    @else
        @include('partials.header')
    @endauth

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @yield('js-files')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>