<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'datetime_start',
        'datetime_end',
        'time',
    ];

    public function questions() 
    {
        return $this->belongsToMany(Question::class, 'exam_question');
    }
}
