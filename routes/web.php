<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

    //User
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    
    //Password
    Route::get('/change-password', [ChangePasswordController::class, 'create'])->name('change.password');
    Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('store.password');

    //Question
    Route::get('/questions', [QuestionController::class, 'index'])->name('question.index');
    Route::get('/questions/search', [QuestionController::class, 'search'])->name('questions.search');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('question.create');
    Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('question.show');
    Route::post('/questions', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('question.update');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('question.destroy');
    

     //Exam
     Route::get('/exams', [ExamController::class, 'index'])->name('exam.index');
     Route::get('/exams/create', [ExamController::class, 'create'])->name('exam.create');
     Route::get('/exams/{id}', [ExamController::class, 'show'])->name('exam.show');
     Route::post('/exams', [ExamController::class, 'store'])->name('exam.store');
     Route::get('/exams/{id}/edit', [ExamController::class, 'edit'])->name('exam.edit');
     Route::put('/exams/{id}', [ExamController::class, 'update'])->name('exam.update');
     Route::delete('/exams/{id}', [ExamController::class, 'destroy'])->name('exam.destroy');
     Route::get('/exams/start/{id}', [ExamController::class, 'start'])->name('exam.start');
     Route::post('/exams/start/{id}', [ExamController::class, 'send'])->name('exam.send');

     Route::get('/exams/{exam}/answers/{class}', [ExamController::class, 'listAnswersByClass'])->name('exams.answers.byclass');
     Route::get('/exams/{exam}/answers/{user}/grading', [ExamController::class, 'editGrading'])->name('exams.grading.edit');
     Route::put('/exams/{exam}/answers', [ExamController::class, 'updateGrading'])->name('exams.grading.update');

     //Log
     Route::post('/logs/registrar', [LogController::class, 'registrarLog'])->name('logs.registrar');

     //Class
     Route::get('/classes/', [ClassController::class, 'index'])->name('classes.index');
     Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
     Route::post('/classes/join/{id}', [ClassController::class, 'join'])->name('classes.join');  
     Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
     Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
     Route::get('/classes/{class}/assign-exam', [ClassController::class, 'showAssignExamForm'])->name('classes.showAssignExamForm');
     Route::post('/classes/{class}/assign-exam', [ClassController::class, 'assignExam'])->name('classes.assignExam');

});

require __DIR__.'/auth.php';
