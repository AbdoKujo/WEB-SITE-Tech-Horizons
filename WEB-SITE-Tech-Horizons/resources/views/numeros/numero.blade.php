<!-- filepath: /c:/Users/Abdo/projects/TechHorizons0/resources/views/numeros/numero.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:30px">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 1.5rem; font-weight: bold; color: #111827;">{{ $numero->name }}</h1>
    </div>

    <h6 style="margin-bottom:30px">This numero features the most popular articles on Tech Horizons. Dive in to explore trending topics!</h6>

    @if ($numero->articles->isEmpty())
        <p>No articles found for this numero.</p>
    @else
        <div class="row">
            @foreach ($numero->articles as $article)
                @if ($isResponsable || $isEditeur || ($isAbonne && $article->id_numero) || (!$isResponsable && !$isEditeur && !$isAbonne && strtolower(trim($article->status)) === 'publié'))
                    <div class="col-md-4 mb-4">
                        <div class="card" style="background-color:rgb(240, 240, 240)">
                            <div class="card-body">
                                <div style="text-align: center;margin-bottom :20px">
                                    <a href="{{ route('articles.show', $article->id) }}">
                                        <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}" style="max-width: 100%; height: auto; border-radius: 15px;">
                                    </a>
                                </div>
                                <a href="{{ route('articles.show', $article->id) }}" style="text-decoration: none">
                                    <h5 class="card-title" style="color:#111827"><strong>{{ $article->title }}</strong></h5>
                                </a>
                                <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                                <p class="card-text"><small class="text-muted">Status: {{ $article->status }}</small></p>

                                <!-- Actions pour responsable et éditeur -->
                                @if (isset($isResponsable) && $isResponsable)
                                    @if ($article->status === 'En cours')
                                        <form method="POST" action="{{ route('articles.approve', $article->id) }}" style="display: inline-block; margin-right: 5px;">
                                            @csrf
                                            <button type="submit" name="action" value="approve" style="background:rgb(47, 134, 36);color:white;border:none;padding:10px 15px;border-radius:5px;">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('articles.reject', $article->id) }}" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" name="action" value="refuse" style="background:rgb(139, 40, 33);color:white;border:none;padding:10px 15px;border-radius:5px;">Refuse</button>
                                        </form>
                                    @endif
                                    @if (strtolower(trim($article->status)) === 'publié')
                                        <form method="POST" action="{{ route('themes.articles.delete', $article->id) }}" style="text-align: right;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background-color: #ef3b2d; color: white; border: none; padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;">Delete Article</button>
                                        </form>
                                    @endif
                                @endif

                                @if (isset($isEditeur) && $isEditeur)
                                    <form method="POST" action="{{ route('themes.articles.delete', $article->id) }}" class="delete-form" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:#ef3b2d;color:white;border:none;padding:10px 15px;border-radius:5px;">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection