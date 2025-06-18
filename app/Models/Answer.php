<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'puppy_id', 'question_id', 'answer', 'file_path'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function puppy()
    {
        return $this->belongsTo(Puppy::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function breeder()
    {
        return $this->belongsTo(BreederProfile::class);
    }
}