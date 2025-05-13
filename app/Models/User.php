<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Friendship;
use App\Models\Message;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'birthday',
        'country',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Purchases made by the user.
     */
    public function purchases()
    {
        return $this->hasMany(\App\Models\Purchase::class);
    }

    /**
     * Balance transactions for the user.
     */
    public function userBalanceTransactions()
    {
        return $this->hasMany(\App\Models\BalanceTransaction::class, 'user_id');
    }

    /**
     * One-to-one relationship to the user's balance.
     */
    public function balance()
    {
        return $this->hasOne(\App\Models\UserBalance::class, 'user_id');
    }

    /**
     * Friend requests sent by this user.
     */
    public function sentRequests()
    {
        return $this->hasMany(Friendship::class, 'requester_id');
    }

    /**
     * Friend requests received by this user.
     */
    public function receivedRequests()
    {
        return $this->hasMany(Friendship::class, 'requested_id');
    }

    /**
     * All accepted friends (bidirectional).
     */
   // In User model
public function friends()
{
    return $this->belongsToMany(User::class, 'friendships', 'requester_id', 'requested_id')
                ->wherePivot('status', 'accepted');
}

public function sentFriendRequests()
{
    return $this->hasMany(Friendship::class, 'requester_id');
}

public function receivedFriendRequests()
{
    return $this->hasMany(Friendship::class, 'requested_id');
}

}