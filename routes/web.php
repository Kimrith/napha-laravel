<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'dashboard'])->name('home');

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/students', [PageController::class, 'students'])->name('students.index');
Route::get('/courses', [PageController::class, 'courses'])->name('courses.index');
Route::get('/attendance', [PageController::class, 'attendance'])->name('attendance.index');
Route::get('/grades', [PageController::class, 'grades'])->name('grades.index');
Route::get('/departments', [PageController::class, 'departments'])->name('departments.index');
Route::get('/settings', [PageController::class, 'settings'])->name('settings.index');
