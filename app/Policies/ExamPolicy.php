<?php

namespace App\Policies;

use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExamPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isDocente();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Exam $exam): bool
    {
        if($user->isDocente() && $user->id === $exam->created_by)
        {
            return true;
        }

        if ($user->isDiscente()) {
            foreach ($exam->class as $class) {
                if ($class->participants->contains($user->id)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isDocente();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Exam $exam): bool
    {
        return $user->isDocente() && $user->id === $exam->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Exam $exam): bool
    {
        return $user->isDocente() && $user->id === $exam->created_by;
    }

    /**
     * Determine whether the user can start the exam.
     */
    public function start(User $user, Exam $exam): bool
    {
        $now = now();
        $startDateTime = $exam->datetime_start;
        $endDateTime = $exam->datetime_end;

        if ($user->isDiscente()) {
            foreach ($exam->class as $class) {
                if ($class->participants->contains($user->id) && $now >= $startDateTime && $now <= $endDateTime) {
                    // Verificar se o usuário já respondeu a prova
                    if (!$user->answers()->where('exam_id', $exam->id)->exists()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function editGrading(User $user, Exam $exam)
    {
        foreach($exam->class as $class)
        {
            if($user->id === $class->createdBy->id)
            {
                return true;
            }
        }
        return false;
    }

    public function updateGrading(User $user, Exam $exam)
    {
        foreach($exam->class as $class)
        {
            if($user->id === $class->createdBy->id)
            {
                return true;
            }
        }
        return false;
    }
}
