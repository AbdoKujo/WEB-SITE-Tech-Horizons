<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'item_id',
        'visited_at',
    ];
    public function theme()
{
    return $this->belongsTo(Theme::class, 'item_id');
}

public function article()
{
    return $this->belongsTo(Article::class, 'item_id');
}
}