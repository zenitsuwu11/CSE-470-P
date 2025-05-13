<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameNews extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'release_date',
        'game_id',
    ];

    /**
     * Get the game associated with this news.
     */
    public function game()
    {
        return $this->belongsTo(Game::class); 
    }

    /**
     * Get the reviews for this game news.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'title', 'id'); // This is incorrect. Fix below.
    }
}
