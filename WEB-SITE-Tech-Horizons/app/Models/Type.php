<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name']; // Allow mass assignment for the 'name' field

    public function theme()
{
    return $this->belongsTo(Theme::class);
}
}