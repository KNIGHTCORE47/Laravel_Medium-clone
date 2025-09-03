<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Follower extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'followers';

    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationship with the User model [Many to One] [The user being followed]
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the User model [Many to One] [The user who is following (the follower)]
    public function follower()
    {
        return $this->belongsTo(User::class);
    }
}
