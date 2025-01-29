<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type_id',
        'theme_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoleAttribute()
    {
        return $this->type->name;
    }

    // In app/Models/User.php
public function isEditeur()
{
    return $this->role === 'Editeur'; // Ensure 'role' is a valid attribute
}

public function isResponsable()
{
    return $this->role === 'Responsable'; // Ensure 'role' is a valid attribute
}

public function isAbonne()
{
    return $this->role === 'Abonné'; // Ensure 'role' is a valid attribute
}
    public function isResponsableForTheme($themeId)
    {
        return $this->isResponsable() && $this->id === Theme::find($themeId)->responsable_id;
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function themes()
    {
        return $this->belongsToMany(Theme::class)->withTimestamps();
    }

    public function articles()
{
    return $this->hasMany(Article::class, 'user_id');
}

}