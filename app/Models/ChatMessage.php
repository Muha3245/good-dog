<?php
// app/Models/ChatMessage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'message',
        'voice_path',
        'file_path',
        'file_name',
        'file_type',
        'is_read',
        'read_at',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    // Relationship to conversation
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    // Relationship to sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship to receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    // Check if message is a questionnaire submission card
    public function isQuestionnaireCard()
    {
        return isset($this->metadata['type']) && 
               $this->metadata['type'] === 'questionnaire_submission';
    }

    // Get the card data if this is a card message
    public function getCardData()
    {
        return $this->isQuestionnaireCard() ? $this->metadata : null;
    }
}