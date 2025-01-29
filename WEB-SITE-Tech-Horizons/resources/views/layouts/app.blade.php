<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/css/home/style.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/home/dark-theme.css') }}" id="dark-theme">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <header>
            <div class="nav container">
                <a href="{{ url('/') }}" class="logo">Tech <span>Horizons</span></a>                
                @if (Auth::user())
                    <nav class="navbar">
                        <a href="{{ url('/home') }}" class="navC">Home</a>
                        <a href="{{ url('/dashboard') }}" class="navC">Dashboard</a>
                        <a href="{{ url('/suggestions') }}" class="navC">Suggestions</a>
                        <a href="{{ url('/history') }}" class="navC">History</a>
                        <a href="{{ url('/news') }}" class="navC">News</a>
                    </nav>
                @endif

                <div class="auth-links">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="login">{{ __('Login') }}</a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="login ml-4">{{ __('Register') }}</a>
                        @endif
                    @else
                        <div class="dropdown">
                        
                            <a href="#" class="navC" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <i class="fas fa-caret-down"></i>
                            </a>
                        
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <div class="dropdown-item">
                                    <strong>{{ Auth::user()->name }}</strong><br>
                                    <small>{{ Auth::user()->email }}</small><br>
                                    <small>Type: {{ Auth::user()->type->name }}</small>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">
                                    <strong class="fas fa-cog"></strong> Settings
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <strong class="fas fa-sign-out-alt"></strong> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('resources/js/app.js') }}"></script>
</body>
</html>

