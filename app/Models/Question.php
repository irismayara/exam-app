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
        'is_true',
        'created_by',
    ];

    public function isAberta()
    {
        return $this->type == 1;
    }

    public function isMultiplaEscolha()
    {
        return $this->type == 2;
    }

    public function isMultiplasRespostas()
    {
        return $this->type == 3;
    }

    public function isVerdadeiroOuFalso()
    {
        return $this->type == 4;
    }

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
