@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:20px">
    <h1 class="mb-4"><strong>Publications</strong></h1>

    @foreach ($numeros as $numero)
        @if ($numero->status == 'public' || auth()->check())
            <div class="card mb-4">
                <div class="card-header">
                    <h2>{{ $numero->title }}</h2>
                </div>
                <div class="card-body">
                    <p>{{ $numero->description }}</p>
                    <h4>Articles</h4>
                    <ul>
                        @foreach ($numero->articles as $article)
                            <li>
                                <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @endforeach
</div>
@endsection