<?php

namespace App\Policies;

use App\Models\ClassModel;
use App\Models\User;

class ClassPolicy
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
    public function view(User $user): bool
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

    public function join(User $user): bool
    {
        return $user->isDiscente();
    }

    public function update(User $user, ClassModel $class): bool
    {
        return $user->isDocente() && $user->id === $class->created_by;
    }

    public function listAnswersByClass(User $user, ClassModel $class)
    {
        return $user->id === $class->created_by;
    }

}