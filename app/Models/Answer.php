<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'exam_id',
        'user_id',
        'question_id',
        'answer_text',
        'is_true',
        'is_correct',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    public function exam() 
    {
        return $this->belongsTo(Exam::class);
    }
    public function options()
    {
        return $this->belongsToMany(Option::class, 'answers_options', 'answer_id', 'option_id');
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
