<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\RoleController;
use App\Http\Controllers\Web\Admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Additional Admin Routes
|--------------------------------------------------------------------------
|
| These routes handle admin functionality for user management, roles and
| permissions to work with the Spatie Permission system.
|
*/

// Admin routes for user, role and permission management
Route::middleware(['auth', 'verified', 'permission:view user'])->prefix('admin')->name('admin.')->group(function () {
    // User Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create user');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:update user');
    
    // Role Management Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:view role');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:create role');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:view role');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:update role');
    
    // Permission Management Routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:view role');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:create role');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('permission:view role');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:update role');
});

// Department Head Routes
Route::middleware(['auth', 'verified', 'role:department_head'])->prefix('department')->name('department.')->group(function () {
    Route::get('/staff', [App\Http\Controllers\Web\DepartmentController::class, 'staff'])->name('staff');
    Route::get('/courses', [App\Http\Controllers\Web\DepartmentController::class, 'courses'])->name('courses');
    Route::get('/statistics', [App\Http\Controllers\Web\DepartmentController::class, 'statistics'])->name('statistics');
});

// Professor Routes
Route::middleware(['auth', 'verified', 'role:professor'])->prefix('professor')->name('professor.')->group(function () {
    Route::get('/courses', [App\Http\Controllers\Web\ProfessorController::class, 'courses'])->name('courses');
    Route::get('/grades', [App\Http\Controllers\Web\ProfessorController::class, 'grades'])->name('grades');
    Route::get('/attendance', [App\Http\Controllers\Web\ProfessorController::class, 'attendance'])->name('attendance');
});

// Financial Officer Routes
Route::middleware(['auth', 'verified', 'role:financial_officer'])->prefix('financial/admin')->name('financial.admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Web\FinancialController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/payments', [App\Http\Controllers\Web\FinancialController::class, 'adminPayments'])->name('payments');
    Route::get('/scholarships', [App\Http\Controllers\Web\FinancialController::class, 'adminScholarships'])->name('scholarships');
    Route::get('/reports', [App\Http\Controllers\Web\FinancialController::class, 'adminReports'])->name('reports');
});
