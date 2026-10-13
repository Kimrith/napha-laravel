<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Root entry point: unauthenticated users must register first
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('register');
})->name('home');

// Guest authentication routes
Route::middleware('guest')->group(function (): void {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.submit');
});

// Authenticated application routes
Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/search', [SearchController::class, 'search'])->name('global.search');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
    Route::post('/attendance/finalize', [AttendanceController::class, 'finalize'])->name('attendance.finalize');
    Route::post('/attendance/initialize-session', [AttendanceController::class, 'initializeSession'])->name('attendance.initialize-session');
    Route::post('/attendance/toggle-status', [AttendanceController::class, 'toggleStatus'])->name('attendance.toggle-status');
    Route::resource('attendance', AttendanceController::class);

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.password.update');
    Route::put('/settings/term', [SettingController::class, 'updateTerm'])->name('settings.term.update');
});
