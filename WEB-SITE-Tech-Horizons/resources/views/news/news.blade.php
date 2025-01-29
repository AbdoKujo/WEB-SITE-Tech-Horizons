@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css" integrity="sha512-HHsOC+h3najWR7OKiGZtfhFIEzg5VRIPde0kB0bG2QRidTQqf+sbfcxCTB16AcFB93xMjnBIKE29/MjdzXE+qw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('resources/css/news.css') }}">
    <title>News</title>
</head>
<body>
    <!--<div class="header">
        <div class="logo">
            NEWS
        </div>
        <nav >
            <ul>
                <li><a href="#">Breaking News</a></li>
                <li>
                    <select id="themeSelector" class="themeoptions" >
                        <option value="" disabled selected>Themes options</option>
                            @foreach ($themes as $theme)
                            <option value="#{{ $theme->name }}">{{ $theme->name }}</option>
                            @endforeach
                    </select>
                </li>
            </ul>
            <div class="bar">
                <i class="open fa-solid fa-bars-staggered"></i>
                <i class="close fa-solid fa-xmark"></i>
            </div>
        </nav>
    </div>-->
    <select id="themeSelector" class="themeoptions" >
                        <option value="" disabled selected>Themes options</option>
                            @foreach ($themes as $theme)
                            <option value="#{{ $theme->name }}">{{ $theme->name }}</option>
                            @endforeach
                    </select>
    <div class="topHeadlines">
        <div class="left">
            <div class="title">
                <h2>Breaking News</h2>
            </div>
            <div class="slider-container">
                <div class="slider">
                    @foreach ($last as $article)
                    <div class="slider-item">
                        <div class="img" id="breakingImg">
                            <a href="{{ route('articles.show', $article->id) }}">
                                <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}">
                            </a>                        </div>
                        <div class="text" id="breakingNews">
                            <div class="title">
                                <a href="{{ route('articles.show', $article->id) }}" target="_blank"><p>{{ $article->title }}</p></a>
                            </div>
                            <div class="description">
                                {{ $article->content }}
                            </div>
                        </div>
                    </div>        
                    @endforeach
                    </div>
                <a href="#" class="slider-nav prev">&lt;</a>
                <a href="#" class="slider-nav next">&gt;</a>
            </div> 
        </div>
        <div class="right">
            <div class="title">
                <h2>Top Headlines</h2>
            </div>
            <div class="topNews">
            <!-- news content articles -->
                <div class="news">
                    @foreach ($top as $article)
                        <div class="img" >
                            <a href="{{ route('articles.show', $article->id) }}">
                                <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}">
                            </a>                        </div>
                        <div class="text">
                            <div class="title">
                                <a href="{{ route('articles.show', $article->id) }}" target="_blank"><p>{{ $article->title }}</p></a>
                            </div>
                        </div>
                    @endforeach
                </div>`
            </div>

        </div>
    </div>
<div class="page2">
    @foreach ($themes as $themeIndex => $theme)
        <div class="title" >
            <h2 style="--theme-pos: {{ $themeIndex + 1 }} ; text-align: center">{{ $theme->name }} News</h2>
        </div>
        <div class="news" id="{{ $theme->name }}" >
            
            <div class="newsBox slider">
                @foreach ($theme->articles as $articleIndex => $article)
                    <div class="newsCard" style="--pos: {{ $articleIndex + 1 }}">
                        <div class="img">
                            <a href="{{ route('articles.show', $article->id) }}">
                                <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}">
                            </a>
                        </div>
                        <div class="text">
                            <div class="title">
                                <a href="{{ route('articles.show', $article->id) }}" target="_blank">
                                    <p>{{ $article->title }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

    <div class="footer">
        <div class="box">
            <div class="left">
                <div class="categories">
                    <p>Categories</p>
                    @foreach ($themes as $theme)
                    <div>
                        <p>{{ $theme->name }}</p>
                    </div>
                   @endforeach
                </div>
                <div class="contactUs">
                    <div class="contact">
                        <p>Contact Us</p>
                        <div>Phone No. - <span>+212 621086882</span></div>
                        <div>Email - <span>abdo.abiido@gmail.com</span></div>
                        <div>Address - <span>Jbel kbir Tanger</span></div>
                    </div>
                    <div class="icon">
                        <i class="fa-brands fa-square-facebook"></i>
                        <i class="fa-brands fa-instagram"></i>
                        <i class="fa-brands fa-youtube"></i>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="newsletter">
                    <p>Subscribe to Our Newsletter</p>
                    <div class="email">
                        <input type="email" placeholder="Enter Your Email Here">
                        <button>Subscribe</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="copyrights">
            Copyrights &copy; 2025 Tech
        </div>
    </div>
    <script src="{{ asset('resources/js/news.js') }}">
        
    </script>
</body>
</html>
@endsection