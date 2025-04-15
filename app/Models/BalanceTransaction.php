<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransaction extends Model
{
    use HasFactory;

    protected $table = 'user_balance_transactions'; // Correct table name

    protected $fillable = [
        'user_id',
        'game_id',
        'amount',
        'type',
    ];

    // Inverse relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // In Transaction.php
    public function game()
{
    return $this->belongsTo(Game::class);
}

}
