<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    use HasFactory;

    protected $table = 'customer_balances'; // Make sure this matches your actual table

    protected $fillable = [
        'user_id',
        'amount',
    ];

    public $timestamps = true; // Set this to false if your table doesn't have created_at and updated_at
}
