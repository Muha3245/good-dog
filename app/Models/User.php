<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastname',
        'program_name',
        'country',
        'email',
        'password',
        'phone',
        'role',
    ];
    public function breederProfile()
{
    return $this->hasOne(BreederProfile::class);
}
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
 // app/Models/User.php

public function profile()
{
    return $this->hasOne(BreederProfile::class);
}

public function submissions()
{
    return $this->hasMany(Answer::class);
}

public function sentMessages()
{
    return $this->hasMany(ChatMessage::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(ChatMessage::class, 'receiver_id');
}

public function sentMessagesTo($user)
{
    return $this->sentMessages()->where('receiver_id', $user->id);
}

public function unreadMessagesFrom($user)
{
    return $this->receivedMessages()
               ->where('sender_id', $user->id)
               ->where('is_read', false);
}

public function conversations()
{
    return $this->belongsTo(Conversation::class);
}
public function isBreeder()
{
    return $this->role === 'breeder';
}
}
