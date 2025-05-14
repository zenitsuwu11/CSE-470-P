<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'image', 'details', 'price'];

    /**
     * Get the news for the game.
     */
    public function gameNews()
    {
        return $this->hasMany(GameNews::class);  // A game can have many news items
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
