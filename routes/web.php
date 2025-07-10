<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DynamicFormController;

// CSRF Token refresh route
Route::get('/csrf-token', function() {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Session extend route
Route::post('/extend-session', function() {
    if (Auth::check()) {
        session()->regenerate();
        return response()->json(['success' => true, 'csrf_token' => csrf_token()]);
    }
    return response()->json(['success' => false], 401);
})->middleware('auth');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/employee/dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard');
    Route::get('/client/dashboard', [DashboardController::class, 'clientDashboard'])->name('client.dashboard');
});

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('dynamic-forms', DynamicFormController::class);

    // Client-specific routes
    Route::get('/clients/{client}/manage-access', [ClientController::class, 'manageAccess'])->name('clients.manage-access');
});

// Public Dynamic Form Routes (for clients to fill)
Route::get('/forms/{form}', [DynamicFormController::class, 'showPublicForm'])->name('dynamic-forms.public');
Route::post('/forms/{form}/submit', [DynamicFormController::class, 'submitPublicForm'])->name('dynamic-forms.submit');
