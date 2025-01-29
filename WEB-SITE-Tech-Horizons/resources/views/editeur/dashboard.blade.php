@extends('layouts.app')

@section('content')
<div class="container-fluid" style="display: flex; min-height: 100vh; padding: 0;">
    <!-- User Categories Section -->
    <div style="background-color: rgb(224, 224, 224); flex: 1; padding: 20px;">
        <h2 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin-bottom: 15px;">
            <strong>Users</strong>
        </h2>
        <hr style="margin-bottom: 20px;">

        <!-- Responsables Section -->
        <div style="padding: 8px; background-color: rgb(245, 245, 245); border-radius: 6px; margin-bottom: 10px;">
            <h3 style="cursor: pointer; font-size: 1.1rem; font-weight: bold; color: #111827;" onclick="toggleCategory('responsables')">
                <strong>Responsables</strong>
            </h3>
            <ul id="responsables" style="padding-left: 0; display: none;">
                @foreach ($responsables as $user)
                    <li style="margin-bottom: 8px; list-style-type: none;">
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px; background-color: rgb(245, 245, 245); border-radius: 6px; transition: background-color 0.2s;">
                            <span style="font-size: 0.9rem; color: #111827; cursor: pointer; text-decoration: none; transition: text-decoration 0.2s;" 
                                  onmouseover="this.style.textDecoration='underline'" 
                                  onmouseout="this.style.textDecoration='none'" 
                                  onclick="highlightUser(this, {{ $user->id }}); fetchUserDetails({{ $user->id }})">
                                {{ $user->name }}
                            </span>
                            <form action="{{ route('editeur.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirmDeletion()">
                                @csrf
                                <button type="submit" style="background-color: #ef3b2d; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Abonnés Section -->
        <div style="padding: 8px; background-color: rgb(245, 245, 245); border-radius: 6px; margin-bottom: 10px;">
            <h3 style="cursor: pointer; font-size: 1.1rem; font-weight: bold; color: #111827;" onclick="toggleCategory('abonnes')">
                <strong>Abonnés</strong>
            </h3>
            <ul id="abonnes" style="padding-left: 0; display: none;">
                @foreach ($abonnes as $user)
                    <li style="margin-bottom: 8px; list-style-type: none;">
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px; background-color: rgb(245, 245, 245); border-radius: 6px; transition: background-color 0.2s;">
                            <span style="font-size: 0.9rem; color: #111827; cursor: pointer; text-decoration: none; transition: text-decoration 0.2s;" 
                                  onmouseover="this.style.textDecoration='underline'" 
                                  onmouseout="this.style.textDecoration='none'" 
                                  onclick="highlightUser(this, {{ $user->id }}); fetchUserDetails({{ $user->id }})">
                                {{ $user->name }}
                            </span>
                            <form action="{{ route('editeur.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirmDeletion()">
                                @csrf
                                <button type="submit" style="background-color: #ef3b2d; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- User Details Section -->
    <div style="flex: 3; padding: 20px;">
        <h2 style="font-size: 1.25rem; font-weight: bold; color: #111827;" id="user-details-header">
            <strong>User Details</strong>
        </h2>
        <hr>
        <div id="user-details" style="background-color: rgb(245, 245, 245); padding: 20px; border-radius: 8px;">
            <p>Select a user to view details.</p>
        </div>

        <!-- Statistics Section -->
        <div style="margin-top: 30px;">
            <h2 style="font-size: 1.25rem; font-weight: bold; color: #111827;">
                <strong>Statistics</strong>
            </h2>
            <hr>
            <div style="display: flex; gap: 20px; margin-top: 15px;">
                <div style="background-color: rgb(245, 245, 245); padding: 15px; border-radius: 8px; flex: 1;">
                    <h3 style="font-size: 1rem; font-weight: bold; color: #111827;">Total Subscribers</h3>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #111827;">{{ $abonnes->count() }}</p>
                </div>
                <div style="background-color: rgb(245, 245, 245); padding: 15px; border-radius: 8px; flex: 1;">
                    <h3 style="font-size: 1rem; font-weight: bold; color: #111827;">Total Responsables</h3>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #111827;">{{ $responsables->count() }}</p>
                </div>
                <div style="background-color: rgb(245, 245, 245); padding: 15px; border-radius: 8px; flex: 1;">
                    <h3 style="font-size: 1rem; font-weight: bold; color: #111827;">Total Articles</h3>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #111827;">{{ $allArticles->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Additional Actions Section -->
        <div style="margin-top: 30px;">
            <h2 style="font-size: 1.25rem; font-weight: bold; color: #111827;">
                <strong>Actions</strong>
            </h2>
            <hr>
            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <button style="background-color: rgb(170, 170, 170); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Export Data</button>
                <button style="background-color: rgb(105, 105, 105); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Generate Report</button>
                
                <a href="{{ url('/home') }}" style="text-decoration: none;">
                    <button style="background-color: rgb(61, 61, 61); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                        Manage Themes
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle visibility of categories
    function toggleCategory(categoryId) {
        const category = document.getElementById(categoryId);
        category.style.display = category.style.display === 'none' ? 'block' : 'none';
    }

    // Highlight selected user
    function highlightUser(element, userId) {
        const users = document.querySelectorAll('ul li span');
        users.forEach(user => {
            user.parentElement.style.backgroundColor = 'rgb(245, 245, 245)';
            user.style.color = '#111827';
        });
        element.parentElement.style.backgroundColor = '#111827';
        element.style.color = 'white';
    }

    // Fetch and display user details
    async function fetchUserDetails(userId) {
    try {
        console.log('Fetching user details for user ID:', userId);

        const response = await fetch(`/user-details/${userId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const user = await response.json();
        console.log('User details response:', user);

        const details = document.getElementById('user-details');
        details.innerHTML = `
            <p><strong>Name:</strong> ${user.name}</p>
            <p><strong>Email:</strong> ${user.email}</p>
            <p><strong>Type:</strong> ${user.type}</p>
            <div style="margin-left:20px; padding:15px">
                <h5><strong>Suggested Articles</strong></h5>
                ${user.suggestedArticles.length > 0 ? `
                    <div class="row">
                        ${user.suggestedArticles.map(article => `
                            <div class="col-md-2 mb-1">
                                <div class="card" style="width: auto; background-color: rgb(255, 255, 255); padding: 5px; border-radius: 8px;">
                                    <!-- Article Image -->
                                    <div style="text-align: center;">
                                        <a href="/articles/${article.id}">
                                            <img src="/images/articles/default.jpg" alt="${article.title}" style="max-width: 100%; height: 100px; border-radius: 6px; object-fit: cover;">
                                        </a>
                                    </div>
                                    <!-- Article Title -->
                                    <div style="text-align: center; padding: 5px;">
                                        <a href="/articles/${article.id}" style="text-decoration: none;">
                                            <h5 class="card-title" style="color: #111827; font-size: 0.875rem; margin: 0;"><strong>${article.title}</strong></h5>
                                        </a>
                                    </div>
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
        details.innerHTML = `<p style="color: red;">Error loading user details. Please try again.</p>`;
    }
}

    // Confirmation before deletion
    function confirmDeletion() {
        return confirm('Are you sure you want to delete this user?');
    }
</script>
@endsection