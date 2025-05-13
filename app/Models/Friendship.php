<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    // if your table is called "friendships", you don’t need to override $table
    // protected $table = 'friendships';

    protected $fillable = [
        'requester_id',
        'requested_id',
        'status',
    ];
}
