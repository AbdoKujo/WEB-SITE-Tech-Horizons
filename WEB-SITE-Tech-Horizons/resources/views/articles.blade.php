@extends('layouts.app')

@section('content')
<div style="display:flex;align-items: flex-start; gap: 20px; padding: 20px;">
    <div class="container" style="max-width:50%;flex:5;margin-left:100px">
        <div style="background-color: rgb(241, 241, 241); padding: 20px; margin-top: 20px; border-radius: 8px;">
            <h1 style="margin-bottom:20px"><strong>{{ $article->title }}</strong></h1>
            <strong>Theme:</strong> 
            <a href="{{ route('themes.show', $article->theme->id) }}" style="color:rgb(35, 47, 71)"> {{ $article->theme->name }}</a>
            <hr>

            <!-- Add the article image -->
            <div style="margin-top:20px; text-align: center;">
                <img src="{{ $article->getImageUrl() }}" alt="{{ $article->title }}" style="max-width: 100%; height: auto; border-radius: 15px;margin-bottom:20px">
            </div>

            <p>{{ $article->content }}</p>
        </div>

        <hr>
        <strong>Author:</strong> {{ $article->user->name }}</p>

        <!-- Delete Article Button (Visible only to Editeur) -->
        @if (isset($isResponsable) && $isResponsable || isset($isEditeur) && $isEditeur)
            <form method="POST" action="{{ route('articles.destroy', $article->id) }}" style="text-align: right;">
                @csrf
                @method('DELETE')
                <button type="submit" style="background-color: #ef3b2d; color: white; border: none; padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;">Delete Article</button>
            </form>
        @endif
    </div>

    <!-- Rating and Comments System -->
    <div style=" text-align: center;flex:1;margin:60px 80px 0px 60px">
        <h3><strong>Rate this article</strong></h3>
        <div class="rating">
            @for ($i = 1; $i <= 5; $i++)
                <span class="rating-circle {{ $userRating && $userRating->rating == $i ? 'active' : '' }}" data-value="{{ $i }}"></span>
            @endfor
        </div>
        <p>Your rating: <span id="selected-rating">{{ $userRating ? $userRating->rating : '0' }}</span>/5</p>

        <hr>

        <!-- Comments Section -->
        <h3>Comments</h3>

        <div id="comments-container" class="scrollable-comments">
            @forelse ($comments as $comment)
                <div style="margin-bottom: 15px;">
                    <strong>{{ $comment->user->name }}</strong> <small>({{ $comment->created_at->diffForHumans() }})</small>
                    <p>{{ $comment->comment }}</p>

                    <!-- Delete Comment Button (Visible to Responsable and Editeur) -->
                    @if ((auth()->user()->isResponsable() && $article->theme->responsable_id == auth()->id()) || auth()->user()->isEditeur())
                        <button class="delete-comment" data-comment-id="{{ $comment->id }}" style="background-color: #ef3b2d; color: white; border: none; padding: 2px 5px; border-radius: 3px; font-size: 0.8rem;">Delete</button>
                    @endif
                </div>
                <hr>
            @empty
                <p>No comments yet. Be the first to comment!</p>
            @endforelse
        </div>

        <!-- Add a New Comment -->
        <form id="comment-form" style="margin-top: 20px;">
            <textarea id="comment-text" placeholder="Write a comment..." style="width: 100%; height: 80px; border: 1px solid #ccc; border-radius: 8px; padding: 10px;"></textarea>
            <button type="button" id="submit-comment" 
                    style="margin-top: 10px; padding: 10px 20px; background-color: #111827; color: white; border: none; border-radius: 5px;">
                Submit
            </button>
        </form>

<!-- Add the "Disable Comments" button -->
@if ((isset($isResponsable) && $isResponsable && isset($article->theme->responsable_id) && $article->theme->responsable_id == auth()->id()) || (isset($isEditeur) && $isEditeur))
    <button id="toggle-comments-btn" 
            style="margin-top: 10px; padding: 10px 20px; background-color: #111827; color: white; border: none; border-radius: 5px;">
        Disable Comments
    </button>
@endif


<!-- Comment Form -->





    </div>
</div>

<!-- JavaScript for Rating, Comments, and Admin Actions -->
<script>
    
    const ratingCircles = document.querySelectorAll('.rating-circle');
    const selectedRating = document.getElementById('selected-rating');

    // Rating System
    ratingCircles.forEach(circle => {
        circle.addEventListener('click', () => {
            const value = circle.getAttribute('data-value');
            selectedRating.textContent = value;

            // Highlight the selected rating
            ratingCircles.forEach(c => c.classList.remove('active'));
            circle.classList.add('active');

            // Send the rating to the server
            fetch(`/articles/{{ $article->id }}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rating: value })
            })
            .then(response => response.json())
            .then(data => {
                //alert(data.message); // Show success message
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    // Comments System
    document.getElementById('submit-comment').addEventListener('click', () => {
        const commentText = document.getElementById('comment-text').value;

        if (commentText.trim() === '') {
            alert('Comment cannot be empty.');
            return;
        }

        fetch(`/articles/{{ $article->id }}/rate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ comment: commentText })
        })
        .then(response => response.json())
        .then(data => {
            //alert(data.message); 
            location.reload(); // Reload to display the new comment
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });


    // Scroll to the bottom of the comments section
    document.addEventListener('DOMContentLoaded', function() {
        const commentsContainer = document.getElementById('comments-container');
        commentsContainer.scrollTop = commentsContainer.scrollHeight;
    });





// Delete Comment
document.querySelectorAll('.delete-comment').forEach(button => {
    button.addEventListener('click', () => {
        const commentId = button.getAttribute('data-comment-id');

        fetch(`/articles/comment/${commentId}/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            location.reload(); // Reload to reflect the deletion
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

// Delete Article
document.querySelector('form[action="{{ route('articles.destroy', $article->id) }}"]').addEventListener('submit', function(event) {
    event.preventDefault();
    if (confirm('Are you sure you want to delete this article?')) {
        this.submit();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const toggleCommentsBtn = document.getElementById('toggle-comments-btn');
    const submitCommentBtn = document.getElementById('submit-comment');

    if (toggleCommentsBtn) {
        let commentsDisabled = false; // Track the state of comments

        toggleCommentsBtn.addEventListener('click', () => {
            commentsDisabled = !commentsDisabled; // Toggle the state

            // Update the Submit button's disabled state
            submitCommentBtn.disabled = commentsDisabled;

            // Update the text of the "Disable Comments" button
            toggleCommentsBtn.textContent = commentsDisabled ? 'Enable Comments' : 'Disable Comments';
        });
    }
});

</script>

<!-- Add CSS for Rating Circles -->
<style>
    .rating {
        display: flex;
        justify-content: center;
        gap: 10px; /* Space between circles */
    }

    .rating-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #ccc; /* Default gray color */
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .rating-circle:hover {
        background-color: #ef3b2d; /* Yellow on hover */
    }

    .rating-circle.active {
        background-color: #ef3b2d; /* Yellow for selected rating */
    }
    .scrollable-comments {
    text-align: left;
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    max-height: 300px; /* Limit height */
    overflow-y: auto; /* Enable vertical scrolling */
    background-color: #f9f9f9; /* Light background for readability */
    }

    /* Optional: Style the scrollbar (WebKit-based browsers) */
    .scrollable-comments::-webkit-scrollbar {
        width: 10px;
    }

    .scrollable-comments::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 4px;
    }

    .scrollable-comments::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }
    /* Style for the disabled Submit button */
#submit-comment:disabled {
    background-color: #cccccc; /* Gray background */
    color: #666666; /* Darker gray text */
    cursor: not-allowed; /* Show "not allowed" cursor */
    opacity: 0.7; /* Slightly transparent */
}
</style>

@endsection