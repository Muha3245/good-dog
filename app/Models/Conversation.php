<?php
// app/Models/Conversation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'breeder_id',
        'user_id',
        'puppy_id',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // Relationship to the breeder
    public function breeder()
    {
        return $this->belongsTo(BreederProfile::class, 'breeder_id');
    }

    // Relationship to the user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to the puppy
    public function puppy()
    {
        return $this->belongsTo(Puppy::class);
    }

    // Relationship to messages
    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->latest();
    }

    // Latest message accessor
    public function getLatestMessageAttribute()
    {
        return $this->messages()->first();
    }

    // Mark all messages as read for a specific user
    public function markAsReadForUser($userId)
    {
        $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }
}