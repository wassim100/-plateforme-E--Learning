<?php

use Illuminate\Support\Facades\Route;

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
Route::view('/courses', 'front.pages.courses.index');
Route::view('/teachers', 'front.pages.teachers.index');
Route::view('/contact', 'front.pages.contact');
Route::view('/profile', 'front.pages.profile');
// simple placeholder for search results (reuses courses list for now)
Route::view('/search', 'front.pages.courses.index');

/*
|--------------------------------------------------------------------------
| Admin routes (placeholder views, controllers later)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.pages.dashboard');
    // Resource routes
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)
        ->names('admin.categories');
    // Placeholder views for others
    Route::view('/users', 'admin.pages.users.index');
    Route::view('/courses', 'admin.pages.courses.index');
    Route::view('/enrollments', 'admin.pages.enrollments.index');
    Route::view('/quizzes', 'admin.pages.quizzes.index');
    Route::view('/questions', 'admin.pages.questions.index');
    Route::view('/answers', 'admin.pages.answers.index');
});
