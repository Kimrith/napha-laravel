<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'dashboard'])->name('home');

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
Route::post('/students/batch-assign', [StudentController::class, 'batchAssign'])->name('students.batch-assign');
Route::post('/students/batch-status', [StudentController::class, 'batchStatus'])->name('students.batch-status');
Route::post('/students/batch-delete', [StudentController::class, 'batchDelete'])->name('students.batch-delete');
Route::resource('students', StudentController::class);

Route::resource('classes', ClassController::class);
Route::get('/classs', [ClassController::class, 'index'])->name('classes.alias');
Route::post('/classes/{class}/assign', [ClassController::class, 'assignStudents'])->name('classes.assign');
Route::delete('/classes/{class}/students/{student}', [ClassController::class, 'removeStudent'])->name('classes.remove-student');

Route::resource('departments', DepartmentController::class);

Route::resource('courses', CourseController::class);

Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
Route::post('/attendance/finalize', [AttendanceController::class, 'finalize'])->name('attendance.finalize');
Route::post('/attendance/initialize-session', [AttendanceController::class, 'initializeSession'])->name('attendance.initialize-session');
Route::resource('attendance', AttendanceController::class);

Route::get('/settings', [PageController::class, 'settings'])->name('settings.index');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
