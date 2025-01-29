@php
use App\Models\Article;
$numeros = Article::select('id_numero')->distinct()->get();
@endphp

@extends('layouts.app')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1, h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .btn-primary { background-color: #3498db; color: white; }
        .btn-success { background-color: #2ecc71; color: white; }
        .btn-danger { background-color: #e74c3c; color: white; }
        
        .btn:hover { opacity: 0.8; }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .toggle-button {
            cursor: pointer;
            color: #3498db;
            text-decoration: underline;
        }
        
        .toggle-content {
            display: none;
        }
        
        .toggle-content.show {
            display: block;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .favoris {
            background-color: #d4edda;
        }
    </style>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (auth()->user()->isEditeur())
            <h1 class="toggle-button" data-target="addForm">Ajouter une Article</h1>
            <div class="toggle-content" id="addForm">
        @else
            <h1>Propose Articles</h1>
            <p>Your article will be reviewed before it gets published.</p>
        @endif

        <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Article Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="theme_id">Theme</label>
                <select name="theme_id" id="theme_id" class="form-control" required>
                    <option value="" disabled selected>--Select a Theme--</option>
                    @foreach($themes as $theme)
                        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                    @endforeach
                </select>
            </div>
            @if (auth()->user()->isEditeur())
                <div class="form-group">
                    <label for="numero_id">Numero</label>
                    <select name="numero_id" id="numero_id" class="form-control" required>
                        <option value="" disabled selected>--Select a numero--</option>
                        @foreach($numeross as $numeros)
                            <option value="{{ $numeros->id }}">{{ $numeros->title}}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        @if (auth()->user()->isEditeur())
            </div>
<br>
            <h1 class="toggle-button" data-target="addNumero">Ajouter un Numéro</h1>
            <div id="addNumero" class="toggle-content">
                <p>Créer un nouveau numéro en sélectionnant parmi les articles retenus et favorisés.</p>

                <form method="POST" action="{{ route('numeros.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="numero_title">Titre du Numéro</label>
                        <input type="text" class="form-control" id="numero_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="numero_description">Description du Numéro</label>
                        <textarea class="form-control" id="numero_description" name="description" required></textarea>
                    </div>
                    
                    <h2>Sélectionner les Articles</h2>
                    <table>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAllNewNumero"></th>
                                <th>Titre de l'Article</th>
                                <th>Favoris</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                                @if($article->status == 'retenu' && $article->id_numero == null)
                                    <tr class="{{ $article->is_favorise ? 'favoris' : '' }}">
                                        <td><input type="checkbox" name="articles[]" value="{{ $article->id }}"></td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->is_favorise ? 'Oui' : 'Non' }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    
                    <button type="submit" class="btn btn-primary">Créer le Numéro</button>
                </form>
            </div>
<br>
            <h1 class="toggle-button" data-target="suggestions-content">Full Suggestions</h1>
            <div id="suggestions-content" class="toggle-content">
                <p>Review all suggested articles.</p>

                @if ($suggestions->isEmpty())
                    <p>No suggestions found.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAllSuggestions"></th>
                                <th>Title</th>
                                <th>Suggested by</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suggestions as $article)
                                <tr>
                                    <td><input type="checkbox" name="selected_articles[]" value="{{ $article->id }}"></td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->user?->name ?? 'Unknown' }}</td>
                                    <td>{{ $article->status }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('articles.approve', $article->id) }}" class="inline-form">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Approuver</button>
                                        </form>
                                        <form method="POST" action="{{ route('articles.reject', $article->id) }}" class="inline-form">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Rejeter</button>
                                        </form>
                                        <form method="POST" action="{{ route('articles.publish', $article->id) }}" class="inline-form">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Publier</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-actions">
                        <button type="button" class="btn btn-success" id="approveSelected">Approuver la sélection</button>
                        <button type="button" class="btn btn-danger" id="rejectSelected">Rejeter la sélection</button>
                        <button type="button" class="btn btn-primary" id="publishSelected">Publier la sélection</button>
                    </div>
                @endif
            </div>
        @endif
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle functionality
            document.querySelectorAll('.toggle-button').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const content = document.getElementById(targetId);
                    content.classList.toggle('show');
                });
            });

            // Check all functionality
            function handleCheckAll(checkAllId, checkboxName) {
                const checkAll = document.getElementById(checkAllId);
                if (checkAll) {
                    checkAll.addEventListener('click', function() {
                        const checkboxes = document.querySelectorAll(`input[name="${checkboxName}"]`);
                        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                    });
                }
            }

            handleCheckAll('checkAllSuggestions', 'selected_articles[]');
            handleCheckAll('checkAllNewNumero', 'articles[]');

            // Bulk actions for suggestions
            function performBulkAction(action) {
        const selectedArticles = Array.from(document.querySelectorAll('input[name="selected_articles[]"]:checked')).map(cb => cb.value);
        if (selectedArticles.length > 0) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/articles/bulk-action';
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            form.appendChild(actionInput);

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfInput);

            selectedArticles.forEach(articleId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'articles[]';
                input.value = articleId;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        } else {
            alert('Veuillez sélectionner au moins un article.');
        }
    }

    // Gestionnaires d'événements pour les boutons d'action en masse
    document.getElementById('approveSelected')?.addEventListener('click', () => performBulkAction('approve'));
    document.getElementById('rejectSelected')?.addEventListener('click', () => performBulkAction('reject'));
    document.getElementById('publishSelected')?.addEventListener('click', () => performBulkAction('publish'));

            // Delete confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    if (confirm('Are you sure you want to delete this article?')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection