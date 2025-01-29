@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #4a90e2;
        --secondary-color: #f5f5f5;
        --text-color: #333;
        --accent-color: #e74c3c;
        --success-color: #2ecc71;
    }
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f0f2f5;
        color: var(--text-color);
    }
    .dashboard-container {
        display: flex;
        min-height: 100vh;
        padding: 20px;
    }
    .sidebar {
        flex: 1;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-right: 20px;
    }
    .main-content {
        flex: 3;
    }
    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    .user-list {
        list-style-type: none;
        padding: 0;
    }
    .user-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        background-color: var(--secondary-color);
        border-radius: 8px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    .user-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .user-name {
        font-weight: bold;
        cursor: pointer;
    }
    .user-email {
        color: #6B7280;
    }
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-danger {
        background-color: var(--accent-color);
        color: white;
    }
    .btn-success {
        background-color: var(--success-color);
        color: white;
    }
    .btn:hover {
        opacity: 0.8;
    }
    .stats-container {
        display: flex;
        gap: 20px;
    }
    .stat-card {
        flex: 1;
        background-color: white;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        color: var(--primary-color);
    }
    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    .article-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    .article-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .article-content {
        padding: 15px;
    }
    .article-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .article-status {
        font-size: 0.9rem;
        color: #6B7280;
    }
</style>

<div class="dashboard-container">
    <!-- Subscribed Users Section -->
    <div class="sidebar">
        <h2 class="section-title">Subscribed Users</h2>
        <ul class="user-list">
        @foreach ($subscribedUsers as $user)
            <li class="user-item">
                <span class="user-name" onclick="highlightUser(this, {{ $user->id }}); fetchUserDetails({{ $user->id }})">
                    {{ $user->name }}
                </span>
                <form action="{{ route('responsable.unsubscribe', ['themeId' => $managedThemes->first()->id, 'userId' => $user->id]) }}" method="POST" onsubmit="return confirmUnsubscribe()">
                    @csrf
                    <button type="submit" class="btn btn-danger">Unsubscribe</button>
                </form>
            </li>
        @endforeach
        </ul>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <!-- User Details Section -->
        <div id="user-details" class="card">
            <h2 class="section-title">User Details</h2>
            <p>Select a user to view details.</p>
        </div>

        <!-- Statistics Section -->
        <div class="card">
            <h2 class="section-title">Statistics</h2>
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Subscribers</h3>
                    <p class="stat-value">{{ $subscribedUsers->count() }}</p>
                </div>
                <div class="stat-card">
                    <h3>Total Articles</h3>
                    <p class="stat-value">{{ $suggestedArticles->count() }}</p>
                </div>
                <div class="stat-card">
                    <h3>Pending Approvals</h3>
                    <p class="stat-value">{{ $suggestedArticles->where('status', 'En cours')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Suggested Articles Section -->
        <div class="card">
            <h2 class="section-title">Your Theme Articles</h2>
            <div class="articles-grid">
                @foreach ($suggestedArticles as $article)
                    <div class="article-card">
                        <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}" class="article-image">
                        <div class="article-content">
                            <h5 class="article-title">{{ $article->title }}</h5>
                            <p>{{ Str::limit($article->content, 100) }}</p>
                            <p class="article-status">Status: {{ $article->status }}</p>
                            @if ($article->status === 'En cours')
                                <form method="POST" action="{{ route('articles.approve', $article->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('articles.reject', $article->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" name="action"  value="refuse" class="btn btn-danger">Refuse</button>
                                </form>
                            @else 
                                <form action="{{ route('dashboard.articles.delete', $article->id) }}" method="POST" style="display: inline;" onsubmit="return confirmDeletion()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <form method="POST" action="{{ $article->is_favorise ? route('articles.unfavorite', $article->id) : route('articles.favorite', $article->id) }}" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn {{ $article->is_favorise ? 'btn-danger' : 'btn-success' }}">
                                    {{ $article->is_favorise ? 'Défavoriser' : 'Favoriser' }}
                                </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Additional Actions Section -->
        <div class="card">
            <a href="{{ url('/suggestions') }}" class="btn btn-primary">Create Article</a>
        </div>
    </div>
</div>

<script>
    function highlightUser(element, userId) {
        const users = document.querySelectorAll('.user-item');
        users.forEach(user => {
            user.style.backgroundColor = 'var(--secondary-color)';
            user.querySelector('.user-name').style.color = 'var(--text-color)';
        });
        element.closest('.user-item').style.backgroundColor = 'var(--primary-color)';
        element.style.color = 'white';
    }

    async function fetchUserDetails(userId) {
        try {
            const response = await fetch(`/user-details/${userId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const user = await response.json();
            const details = document.getElementById('user-details');
            details.innerHTML = `
                <h2 class="section-title">User Details</h2>
                <p><strong>Name:</strong> ${user.name}</p>
                <p><strong>Email:</strong> ${user.email}</p>
                <p><strong>Type:</strong> ${user.type}</p>
                <div class="card">
                    <h3 class="section-title">Suggested Articles</h3>
                    ${user.suggestedArticles.length > 0 ? `
                        <div class="articles-grid">
                            ${user.suggestedArticles.map(article => `
                                <div class="article-card">
                                    <img src="${article.image || '/images/articles/default.jpg'}" alt="${article.title}" class="article-image">
                                    <div class="article-content">
                                        <h5 class="article-title">${article.title}</h5>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `<p>No suggested articles.</p>`}
                </div>
            `;
        } catch (error) {
            console.error('Error fetching user details:', error);
            const details = document.getElementById('user-details');
            details.innerHTML = `<p style="color: var(--accent-color);">Error loading user details. Please try again.</p>`;
        }
    }

    function confirmUnsubscribe() {
        return confirm('Are you sure you want to unsubscribe this user?');
    }

    function confirmDeletion() {
        return confirm('Are you sure you want to delete this article?');
    }
</script>
@endsection