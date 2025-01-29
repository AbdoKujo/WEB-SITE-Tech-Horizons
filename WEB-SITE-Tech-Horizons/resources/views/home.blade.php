
@extends('layouts.app')
<link rel="stylesheet" href="{{asset('resources/css/home/style.css')}}">
<link rel="stylesheet" href="{{asset('resources/css/home/dark-theme.css')}}">

<script src="{{ asset('resources/js/home.js') }}"></script>
@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f2f5;
        color: #333;
    }
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    .hero-section {
        background: linear-gradient(135deg, #6366F1, #8B5CF6);
        color: white;
        padding: 3rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #4B5563;
    }
    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1F2937;
    }
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-primary {
        background-color: #3B82F6;
        color: white;
    }
    .btn-primary:hover {
        background-color: #2563EB;
    }
    .btn-danger {
        background-color: #EF4444;
        color: white;
    }
    .btn-danger:hover {
        background-color: #DC2626;
    }
    .theme-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .footer {
        margin-top: 3rem;
        text-align: center;
        color: #6B7280;
    }
/* Slider styles */
        .slider-container {
            position: relative;
            overflow: hidden;
            width: 60%;
            height: 60%;
            align-items: center;
        }
        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }
        .slider-item {
            flex: 0 0 100%;
        }
        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 50%;
        }
        .slider-nav.prev {
            left: 10px;
        }
        .slider-nav.next {
            right: 10px;
        }
</style>

<div class="dashboard-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">Welcome, {{ Auth::user()->name }}</h1>
        <p class="hero-subtitle">Tech Horizons is your gateway to the latest in technology and innovation</p>
    </div>

    <!-- Latest Read Articles -->
    <div class="mb-4">
        <h5 class="section-title">Your latest read articles</h5>
        @if ($latestArticles->isEmpty())
            <p>No recently read articles.</p>
        @else
            <div class="row">
                @foreach ($latestArticles as $article)
                    <div class="col-md-2 mb-3">
                        <div class="card">
                            <a href="{{ route('articles.show', $article->id) }}">
                                <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}" class="card-img">
                            </a>
                            <div class="p-2">
                                <a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none">
                                    <h5 class="card-title">{{ $article->title }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <div class="text-center mb-4">
        <p class="section-title">Explore the latest articles and updates</p>
    </div>

    <!-- Add Theme Form (Visible to Editeur) -->
    @if (auth()->user()->isEditeur())
        <div class="mb-4">
            <h1 class="section-title text-center">Manage Themes</h1>
            <p><strong>Create a new theme and assign a responsable.</strong></p>

            <form method="POST" action="{{ route('themes.store') }}" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="theme_name" class="form-label">Theme Title</label>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control" id="theme_name" name="name" required>
                        <select name="responsable_id" id="responsable_id" class="form-select">
                            <option value="" disabled selected>--Select a Responsable--</option>
                            @foreach($abonnes as $abonne)
                                <option value="{{ $abonne->id }}">{{ $abonne->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Add Theme</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- Themes List -->
    <div class="theme-grid">
        @foreach ($themes as $theme)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title">
                            <a href="{{ route('themes.show', $theme->id) }}" class="text-decoration-none text-dark">
                                {{ $theme->name }}
                            </a>
                        </h3>

                        @if (auth()->user()->isResponsableForTheme($theme->id))
                            <a href="{{ route('dashboard') }}" class="btn btn-danger">See Details</a>
                        @elseif (auth()->user()->isAbonne() || auth()->user()->isResponsable())
                            <form action="{{ route('themes.subscribe', $theme->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    @if (auth()->user()->themes->contains($theme->id))
                                        Unsubscribe
                                    @else
                                        Subscribe
                                    @endif
                                </button>
                            </form>
                        @endif

                        @if (auth()->user()->isEditeur())
                            <form method="POST" action="{{ route('themes.destroy', $theme->id) }}" class="delete-theme-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                    </div>
                    <p class="text-muted">Discover more about this theme and explore related content.</p>
                    <a href="{{ route('themes.show', $theme->id) }}" class="btn btn-primary w-100">View the theme</a>
                </div>
            </div>
        @endforeach
    </div>
    

    <!-- Manage Numeros (for Editeur) -->
    @if (auth()->user()->isEditeur())
        <div class="mt-4">
            <h2 class="section-title">Gérer les Numéros</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre du Numéro</th>
                        <th>Détails</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($numeros as $numero)
                        <tr>
                            <td>{{ $numero->title }}</td>
                            <td>
                                    <a href="{{ route('numeros.show', $numero->id) }}" >
                                    <button class="btn btn-info" >Voir les articles</button>
                                    </a>
                                <div id="details-{{ $numero->id }}" style="display: none;">
                                    <ul>
                                        @foreach ($numero->articles as $article)
                                            <li>{{ $article->title }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('numeros.edit', $numero->id) }}" class="btn btn-warning">Modifier</a>
                                @if ($numero->status == 'privé')
                                    <form method="POST" action="{{ route('numeros.publish', $numero->id) }}" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Publier</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('numeros.unpublish', $numero->id) }}" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Annuler</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('numeros.destroy', $numero->id) }}" style="display: inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce numéro ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Tech Horizons &copy; {{ now()->year }}. All rights reserved.</p>
        <div class="mt-2">
            <a href="#" class="text-muted me-3">Privacy Policy</a>
            <a href="#" class="text-muted">Terms of Service</a>
        </div>
    </div>
</div>

<script>
    // Confirmation for deleting themes
    document.querySelectorAll('.delete-theme-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this theme?')) {
                this.submit();
            }
        });
    });

    // Toggle details for numeros
    function toggleDetails(numeroId) {
        const detailsDiv = document.getElementById(`details-${numeroId}`);
        if (detailsDiv.style.display === 'none') {
            detailsDiv.style.display = 'block';
        } else {
            detailsDiv.style.display = 'none';
        }
    }
    
// Slider functionality
document.querySelectorAll('.slider-container').forEach(container => {
            const slider = container.querySelector('.slider');
            const prevBtn = container.querySelector('.prev');
            const nextBtn = container.querySelector('.next');
            let slideIndex = 0;

            function showSlide(index) {
                slider.style.transform = `translateX(-${index * 100}%)`;
            }

            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                slideIndex = Math.max(slideIndex - 1, 0);
                showSlide(slideIndex);
            });

            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                slideIndex = Math.min(slideIndex + 1, slider.children.length - 1);
                showSlide(slideIndex);
            });
        });
</script>
@endsection