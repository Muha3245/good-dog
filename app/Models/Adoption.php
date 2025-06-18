<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adoption extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'puppy_id',
        'user_id',
        'breeder_id',
        'status',
        'message',
        'rejection_reason',
        'adoption_date',
        'transaction_id',
        'notes'
    ];

    protected $casts = [
        'adoption_date' => 'date'
    ];

    // Relationships
    public function puppy()
    {
        return $this->belongsTo(Puppy::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breeder()
    {
        return $this->belongsTo(BreederProfile::class, 'breeder_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Helpers
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}