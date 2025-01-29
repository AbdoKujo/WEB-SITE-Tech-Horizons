<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'responsable_id',
    ];

    // Define the relationship with the Article model
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    // Define the relationship with the User model
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // Get the image URL for the theme
    public function getImageUrl()
    {
        $imagePath = public_path("images/articles/{$this->id}.jpg");

        if (file_exists($imagePath)) {
            return asset("images/articles/{$this->id}.jpg");
        }

        return asset("images/articles/default.jpg");
    }
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}