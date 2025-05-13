<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;class Comment extends Model
{
    protected $fillable = ['game_id', 'comment'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}