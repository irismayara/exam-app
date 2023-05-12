<?php

namespace App\Policies;

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
        return $user->isDocente() || $user->isDiscente();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Exam $exam): bool
    {
        return $user->isDocente() || $user->isDiscente();
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
        return $user->isDiscente();
    }

    public function send(User $user, Exam $exam): bool
    {
        return $user->isDiscente();
    }
}
