<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'user_id',
        'theme_id',
        'id_numero',
        'is_favorise',
        'image_path', // Add this line
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getImageUrl()
    {
        // Check if the image path is stored in the database
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }

        // Check if the old image file exists
        $imagePath = public_path("images/articles/{$this->id}.jpg");

        if (file_exists($imagePath)) {
            return asset("images/articles/{$this->id}.jpg");
        }

        // Return a default image if no image is found
        return asset("images/articles/default.jpg");
    }

    public function suggestedBy()
    {
        return $this->belongsTo(User::class, 'suggested_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function numero()
    {
        return $this->belongsTo(Numero::class, 'id_numero');
    }
}