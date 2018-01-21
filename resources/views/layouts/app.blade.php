<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = { csrfToken: '{{ csrf_token() }}' }
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar is-info">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ url('/') }}">
                    <img src="https://bulma.io/images/bulma-logo-white.png" alt="File Hosting" width="112" height="28">
                </a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item" href="{{ url('/') }}">
                        Home
                    </a>
                </div>
                <div class="navbar-end">
                    @guest
                        <a class="navbar-item" href="{{ route('login') }}">Login</a>
                        <a class="navbar-item" href="{{ route('register') }}">Register</a>
                    @else
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">
                                <span class="fa fa-user-o"></span> &nbsp;
                                {{ Auth::user()->name }}
                            </a>

                            <div class="navbar-dropdown is-right">
                                    <a class="navbar-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        @if(Auth::check())
            @include('layouts.notification')
            @include('layouts.file-form')
            @include('layouts.confirm')
            @include('layouts.modal')
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
