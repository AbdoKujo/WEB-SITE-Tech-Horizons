@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title">Modifier le Numéro</h1>

    <form method="POST" action="{{ route('numeros.update', $numero->id) }}">
        @csrf
        <div class="form-group">
            <label for="numero_title" class="form-label">Titre du Numéro</label>
            <input type="text" class="form-control" id="numero_title" name="title" value="{{ $numero->title }}" required>
        </div>
        <div class="form-group">
            <label for="numero_description" class="form-label">Description du Numéro</label>
            <textarea class="form-control" id="numero_description" name="description" required>{{ $numero->description }}</textarea>
        </div>

        <h2 class="section-title">Articles Associés</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAllAssociated"></th>
                        <th>Titre de l'Article</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($numero->articles as $article)
                        <tr>
                            <td><input type="checkbox" name="articles[]" value="{{ $article->id }}"></td>
                            <td><a href="{{ route('articles.show', $article->id) }}" target="_blank">{{ $article->title }}</a></td>
                            <td>
                                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info" target="_blank">Voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="section-title">Ajouter des Articles</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAllAvailable"></th>
                        <th>Titre de l'Article</th>
                        <th>Favoris</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($availableArticles as $article)
                        @if($article->status == 'retenu' && $article->id_numero == null)
                            <tr class="{{ $article->is_favorise ? 'favoris' : '' }}">
                                <td><input type="checkbox" name="add_articles[]" value="{{ $article->id }}"></td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->is_favorise ? 'Oui' : 'Non' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <button type="button" class="btn btn-danger" id="removeSelected">Annuler la Sélection</button>
        </div>
    </form>
</div>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .page-title {
        color: #3498db;
        font-size: 2.5rem;
        margin-bottom: 20px;
    }
    .section-title {
        color: #2c3e50;
        font-size: 1.8rem;
        margin-top: 30px;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .table th, .table td {
        padding: 12px;
        border: 1px solid #ddd;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .table tr.favoris {
        background-color: #d4edda;
    }
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary {
        background-color: #3498db;
        color: white;
    }
    .btn-danger {
        background-color: #e74c3c;
        color: white;
    }
    .btn-info {
        background-color: #2ecc71;
        color: white;
    }
    .form-actions {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAllAssociated = document.getElementById('checkAllAssociated');
    const checkAllAvailable = document.getElementById('checkAllAvailable');
    const removeSelectedBtn = document.getElementById('removeSelected');

    function handleCheckAll(checkAllElement, checkboxName) {
        checkAllElement.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll(`input[name="${checkboxName}"]`);
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    }

    handleCheckAll(checkAllAssociated, 'articles[]');
    handleCheckAll(checkAllAvailable, 'add_articles[]');

    removeSelectedBtn.addEventListener('click', function() {
        const selectedArticles = Array.from(document.querySelectorAll('input[name="articles[]"]:checked')).map(cb => cb.value);
        if (selectedArticles.length > 0) {
            if (confirm('Êtes-vous sûr de vouloir annuler la sélection de ces articles ?')) {
                fetch('{{ route('numeros.removeArticles', $numero->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ articles: selectedArticles })
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            }
        } else {
            alert('Veuillez sélectionner au moins un article à annuler.');
        }
    });
});
</script>
@endsection