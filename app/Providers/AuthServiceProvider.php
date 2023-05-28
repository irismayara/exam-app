<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Exam;
use App\Policies\ExamPolicy;
use App\Models\Question;
use App\Policies\QuestionPolicy;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Models\ClassModel;
use App\Policies\ClassPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Exam::class => ExamPolicy::class,
        Question::class => QuestionPolicy::class,
        User::class => UserPolicy::class,
        ClassModel::class => ClassPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
