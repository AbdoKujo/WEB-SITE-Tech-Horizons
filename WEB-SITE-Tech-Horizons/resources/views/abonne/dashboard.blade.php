@extends('layouts.app')

@section('content')
<div class="container-fluid" style="display: flex; min-height: 100vh; padding: 0">
    <!-- Subscribed Themes Section -->
    <div style="background-color: rgb(224, 224, 224); flex: 1; padding: 20px;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 15px;">
            <strong>Subscribed Themes</strong>
        </h2>
        <hr style="margin-bottom: 20px;">
        <ul style="padding-left: 0;">
            @foreach ($subscribedThemes as $theme)
                <li style="margin-bottom: 10px; list-style-type: none;">
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; background-color: rgb(245, 245, 245); border-radius: 8px">
                        <a href="{{ route('themes.show', $theme->id) }}" style="text-decoration: none; color: inherit; flex: 1;">
                            <span style="font-size: 1rem; color: #111827; transition: color 0.2s ease;">{{ $theme->name }}</span>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Recommended Articles Section -->
    <div style="flex: 3; padding: 20px;">
        <h2><strong>Recommended Articles for You</strong></h2>
        <hr>
        <div class="row">
            @foreach ($recommendedArticles as $article)
                @if (strtolower(trim($article->status)) === 'retenu' || strtolower(trim($article->status)) === 'publié')
                    <div class="col-md-4 mb-4">
                        <div class="card" style="background-color: rgb(240, 240, 240)">
                            <div class="card-body">
                                <!-- Article Image -->
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <a href="{{ route('articles.show', $article->id) }}">
                                        <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}" style="max-width: 100%; height: auto; border-radius: 15px;">
                                    </a>
                                </div>
                                <!-- Article Title -->
                                <a href="{{ route('articles.show', $article->id) }}" style="text-decoration: none">
                                    <h5 class="card-title" style="color: #111827"><strong>{{ $article->title }}</strong></h5>
                                </a>
                                <!-- Article Content (Truncated) -->
                                <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                                <!-- Article Status -->
                                <p class="card-text"><small class="text-muted">Status: {{ $article->status }}</small></p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection