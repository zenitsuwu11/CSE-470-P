<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'game_purchases';  // Make sure this is the correct table name
    protected $fillable = ['user_id', 'game_id', 'amount_spent'];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Game model
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
