<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
        'user_id',
        'article_id',
        'rating',
        'comment',
        'type',
        'state',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Scope for public interactions
    public function scopePublic($query)
    {
        return $query->where('state', 'public');
    }

    // Scope for deleted interactions
    public function scopeDeleted($query)
    {
        return $query->where('state', 'deleted');
    }

    // Scope for ratings
    public function scopeRatings($query)
    {
        return $query->where('type', 'rating');
    }

    // Scope for comments
    public function scopeComments($query)
    {
        return $query->where('type', 'comment');
    }
}