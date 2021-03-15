<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HQWriter</title>

    <link rel="icon" href="{{asset('storage/HQlogo.jpg')}}"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style>
    img {
        max-width: 100%;
        height: 100%;
    }

    .indice{
        font-family: 'Noto Sans KR', sans-serif;
        font-size: 115%;
    }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-gray shadow-sm">
        <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('storage/hqWriter.png')}}" width="100" height="50" class="d-inline-block align-top" alt="">
                </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <div id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-item nav-link active ml-2 indice" href="{{route('projetos.index')}}">Meus projetos</a>
                            <a class="nav-item nav-link active ml-2 indice" href="{{route('painel.index')}}">Painel de roteiros</a>
                            <a class="nav-item nav-link active ml-2 indice" href="{{route('ajuda.index')}}">Ajuda</a>
                            @if(Auth::User()->is_admin==true)
                            <a class="nav-item nav-link active ml-2 indice" href="{{route('admin.index')}}">Gerenciar usuários</a>
                                @endif
                        </div>
                    </div>

                </ul>
            </div>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Olá, {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>


    </div>

    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
