<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Public front routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'front.pages.home');
Route::view('/about', 'front.pages.about');
Route::get('/courses', [\App\Http\Controllers\Front\CourseController::class, 'index'])->name('front.courses.index');
Route::get('/categories', [\App\Http\Controllers\Front\CategoryController::class, 'index'])->name('front.categories.index');
Route::view('/teachers', 'front.pages.teachers.index');
Route::view('/contact', 'front.pages.contact');
Route::view('/profile', 'front.pages.profile');
Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show')->middleware('auth');

// Quiz routes pour les étudiants
Route::middleware('auth')->group(function () {
    Route::get('/quiz/{quiz}', [\App\Http\Controllers\Front\QuizController::class, 'show'])->name('front.quiz.show');
    Route::get('/quiz/{quiz}/take', [\App\Http\Controllers\Front\QuizController::class, 'take'])->name('front.quiz.take');
    Route::post('/quiz/{quiz}/submit', [\App\Http\Controllers\Front\QuizController::class, 'submit'])->name('front.quiz.submit');
    Route::get('/quiz/{quiz}/result', [\App\Http\Controllers\Front\QuizController::class, 'result'])->name('front.quiz.result');
});

// simple placeholder for search results (reuses courses list for now)
Route::view('/search', 'front.pages.courses.index');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\EnsureAdmin::class])->name('admin.')->group(function () {
    Route::view('/', 'admin.pages.dashboard')->name('dashboard');
    
    // Quiz Dashboard
    Route::get('/quiz/dashboard', [\App\Http\Controllers\Admin\QuizDashboardController::class, 'index'])->name('quiz.dashboard');
    Route::get('/quiz/{quiz}/details', [\App\Http\Controllers\Admin\QuizDashboardController::class, 'details'])->name('quiz.details');
    Route::get('/quiz/{quiz}/export', [\App\Http\Controllers\Admin\QuizDashboardController::class, 'export'])->name('quiz.export');
    Route::get('/quiz/result/{result}', [\App\Http\Controllers\Admin\QuizDashboardController::class, 'getResultDetails'])->name('quiz.result.details');

    // Resource routes
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)
        ->names('categories');
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class)
        ->names('courses');
    Route::resource('quizzes', App\Http\Controllers\Admin\QuizController::class)
        ->names('quizzes');
    Route::resource('questions', App\Http\Controllers\Admin\QuestionController::class)
        ->names('questions');
    Route::resource('answers', App\Http\Controllers\Admin\AnswerController::class)
        ->names('answers');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)
        ->names('users');
    Route::resource('enrollments', App\Http\Controllers\Admin\EnrollmentController::class)
        ->names('enrollments');
});
