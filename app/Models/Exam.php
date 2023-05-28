<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExamAttempt;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'datetime_start',
        'datetime_end',
        'time',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions() 
    {
        return $this->belongsToMany(Question::class, 'exam_question');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function class()
    {
        return $this->belongsToMany(ClassModel::class, 'class_exam', 'exam_id', 'class_id');
    }

    public function allWhoAnswered()
    {
        return User::whereHas('answers', function ($query) 
        {
            $query->where('exam_id', $this->id);
        })->get();
    }

    public function usersWhoAnsweredInClass(ClassModel $class)
    {
        return $class->participants()->whereHas('answers', function ($query)
        {
            $query->where('exam_id', $this->id);
        })->get();
    }
    
    public function getResult(User $user)
    {
        $totalQuestions = $this->questions->count();
        $correctAnswers = $user->answers()
            ->where('exam_id', $this->id)
            ->where('is_correct', true)
            ->count();

            $result = "{$correctAnswers}/{$totalQuestions}";

            return $result;
    }

    public function isWithinTimePeriod()
    {
        $now = now();
        $startDateTime = $this->datetime_start;
        $endDateTime = $this->datetime_end;

        return $now >= $startDateTime && $now <= $endDateTime;
    }

    public function hasUserAnswered(User $user)
    {
        return $this->examAttempts()->where('user_id', $user->id)->where('is_submitted', true)->exists();
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
