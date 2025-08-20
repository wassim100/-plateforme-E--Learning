<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Mock admin stats for dashboard
Route::get('/admin/stats', function () {
    return Response::json([
        'users' => [
            'total' => 1280,
            'students' => 1100,
            'tutors' => 150,
            'admins' => 30,
        ],
        'courses' => ['total' => 85],
        'categories' => ['total' => 12],
        'enrollments' => ['total' => 3420],
        'quizzes' => ['total' => 210],
        'questions' => ['total' => 1840],
    ]);
});

// Mock recent users table
Route::get('/recent/users', function () {
    return Response::json([
        ['id' => 101, 'name' => 'Alice Martin', 'email' => 'alice@example.com', 'role' => 'student'],
        ['id' => 102, 'name' => 'Karim Ben', 'email' => 'karim@example.com', 'role' => 'tutor'],
        ['id' => 103, 'name' => 'Sofia Lima', 'email' => 'sofia@example.com', 'role' => 'student'],
        ['id' => 104, 'name' => 'Admin One', 'email' => 'admin1@example.com', 'role' => 'admin'],
    ]);
});

// Mock weekly registrations analytics
Route::get('/analytics/registrations', function () {
    return Response::json([
        'labels' => ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        'data' => [12, 19, 7, 14, 22, 9, 15],
    ]);
});
