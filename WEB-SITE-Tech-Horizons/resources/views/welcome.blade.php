<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="{{ asset('resources/css/home/style.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css//home/dark-theme.css') }}" id="dark-theme">
</head>
<body>
    <header>
        <div class="nav container">
            <a href="#" class="logo">Tech <span>Horizons</span></a>
            <button class="theme-toggle" onclick="toggleTheme()">Dark Mode</button>
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="login">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="login">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 login">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <section class="home" id="home">
        <div class="home-text container">
            <h2 class="home-title">Tech Horizons</h2>
            <span class="home-subtitle">Your gateway to the latest in technology and innovation</span>
        </div>
    </section>


<div class="post-filter container">
    <span class="filter-item active-filter" data-filter="all">All</span>
    @foreach($themes as $theme)
    <span class="filter-item" data-filter="{{ str_replace(' ', '-', strtolower($theme->name)) }}">{{ $theme->name }}</span>
    @endforeach
</div>

<div class="numero-filter container">
    <label for="numero-filter">Filter by Numero:</label>
    <select id="numero-filter" name="numero_id">
        <option value="">All</option>
        @foreach($publishedNumeroIds as $numeroId)
            <option value="{{ $numeroId }}" {{ $selectedNumeroId == $numeroId ? 'selected' : '' }}>Numero {{ $numeroId }}</option>
        @endforeach
    </select>
</div>

<div class="post container">
        @foreach($Narticles as $article)
            <div class="post-box {{ str_replace(' ', '-', strtolower($article->theme->name)) }}">
                <img src="{{ $article->getImageUrl() }}" alt="" class="post-img">
                <h2 class="category">{{ $article->theme->name }}</h2>
                <a href="{{ route('articles.show', $article->id) }}" class="post-title">{{ $article->title }}</a>
                <span class="post-date">{{ $article->created_at->format('d M Y') }}</span>
                <p class="post-description">{{ Str::limit($article->content, 150) }}</p>
                <div class="profile">
                    <img src="" alt="" class="profile-img">
                    <span class="profile-name">{{ $article->user->name }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $Narticles->appends(['id_numero' => $selectedNumeroId])->links() }}
    </div>


    <footer>
        <div class="footer-container">
            <div class="sec aboutus">
                <h2>About Us</h2>
                <p>Tech Horizons is your gateway to the latest in technology and innovation. Explore our themes and stay updated with the latest trends in various tech fields.</p>
                <ul class="sci">
                    <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                    <li><a href="#"><i class="bx bxl-instagram"></i></a></li>
                    <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                    <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="sec quicklinks">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    @foreach($themes as $theme)
                        <li><a href="{{ route('themes.show', $theme->id) }}">{{ $theme->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="sec contactBx">
                <h2>Contact Info</h2>
                <ul class="info">
                    <li>
                        <span><i class='bx bxs-map'></i></span>
                        <span>Tech Horizons HQ<br> Innovation Street<br> Tech City</span>
                    </li>
                    <li>
                        <span><i class='bx bx-envelope' ></i></span>
                        <p><a href="mailto:info@techhorizons.com">info@techhorizons.com</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="{{ asset(path: 'resources/js/home.js') }}"></script>
</body>
</html>

