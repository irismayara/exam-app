<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'type',
        'code',
        'created_by',
    ];

    public function isPrivate()
    {
        return $this->type === 'private';
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'class_exam', 'class_id', 'exam_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    

}
