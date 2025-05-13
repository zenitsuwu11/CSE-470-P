<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'comment',
        'rating',
    ];

    /**
     * Get the game news associated with this review.
     */
    public function gameNews()
    {
        return $this->belongsTo(GameNews::class, 'id'); // Ensure 'game_news_id' exists in reviews table
    }

    /**
     * Get the user associated with this review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
