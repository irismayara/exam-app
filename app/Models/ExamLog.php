<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamLog extends Model
{
    use HasFactory;

    protected $table = 'examlogs';
    public $timestamps = false;

    protected $fillable = ['timestamp', 'user', 'exam_id', 'action', 'question_id', 'details'];
}
