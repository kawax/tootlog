<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'tootlog'))</title>

    <meta name="description" content="@yield('description', 'Mastodon log archives service.')">

    {{--    @stack('robots')--}}

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" sizes="32x32">

    @livewireStyles

    {!! htmlScriptTagJsApi() !!}

    @vite(['resources/js/app.js'])

    <meta name="google-site-verification" content="AjfwegofAkFuyDlrRBsMo8k4y6rpfEri5Qjd7uz3PbQ">
</head>
<body class="theme-{{ auth()->user()->theme ?? 'thin' }}">
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light navbar-laravel bg-white border-bottom navbar-static-top mb-2">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    &nbsp; @auth
                        <li class="nav-item"><a href="{{ url('home') }}" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="{{ route('timeline') }}" class="nav-link">Timeline</a></li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">

                    @if (Auth::guest())
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link" ref="nofollow">Login</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link"
                                                ref="nofollow">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false" v-pre>

                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a href="{{ route('preferences.show') }}" class="dropdown-item">Preferences</a>
                                </li>

                                <li role="separator" class="dropdown-divider"></li>

                                <li>
                                    <a href="{{ route('logout') }}"
                                       class="dropdown-item"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>

            </div>
        </div>
    </nav>

    @yield('content')

    @include('layouts.footer')


</div>

@livewireScripts

<!-- {{ app()->version() }} -->

</body>
</html>
