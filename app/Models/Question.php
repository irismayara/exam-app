<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'question',
        'course',
        'topic',
        'tags',
        'difficulty',
        'type',
        'created_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_question');
    }
}
