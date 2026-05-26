<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Leader\DashboardController as LeaderDashboard;
use App\Http\Controllers\Staff\DashboardController as StaffDashboard;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceSettingController;
use App\Http\Controllers\AttendanceTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckAttendanceController;
use Illuminate\Support\Facades\Route;

// ─── Public ──────────────────────────────────────────────────────────────────
Route::get('/', fn () => redirect()->route('login'));


// ─── Auth ─────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// ─── Admin ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
});

// ─── Leader ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:leader'])->prefix('leader')->name('leader.')->group(function () {
        Route::get('/dashboard', [LeaderDashboard::class, 'index'])->name('dashboard');
});

// ─── Staff ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('dashboard');
});

// ─── Employees ────────────────────────────────────────────────────────────────────
Route::get('/employees', [AttendanceController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [AttendanceController::class, 'createEmployee'])->name('employees.create');
Route::post('/employees', [AttendanceController::class, 'storeEmployee'])->name('employees.store');
Route::delete('/employees/{id}', [AttendanceController::class, 'destroy'])->name('employees.destroy');
Route::get('/employees/{id}/print', [AttendanceController::class, 'printCard'])->name('employees.print');


// ─── សម្រាប់កាមេរ៉ាស្កេន ────────────────────────────────────────────────────────────────────
Route::get('/scanner', [AttendanceController::class, 'scannerView'])->name('attendance.scanner');
Route::post('/api/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');

// ─── Positions ────────────────────────────────────────────────────────────────────
Route::resource('positions', PositionController::class);

// ─── AttendanceTypeController ────────────────────────────────────────────────────────────────────

Route::get('/attendance-settings', [AttendanceSettingController::class, 'index'])->name('attendance-settings.index');
Route::get('/attendance-settings/create', [AttendanceSettingController::class, 'create'])->name('attendance-settings.create');
Route::post('/attendance-settings/store', [AttendanceSettingController::class, 'store'])->name('attendance-settings.store');
Route::get('/attendance-settings/edit/{id}', [AttendanceSettingController::class, 'edit'])->name('attendance-settings.edit');
Route::put('/attendance-settings/update/{id}', [AttendanceSettingController::class, 'update'])->name('attendance-settings.update');
Route::delete('/attendance-settings/delete/{id}', [AttendanceSettingController::class, 'destroy'])->name('attendance-settings.destroy');

// ─── AttendanceTypeController ────────────────────────────────────────────────────────────────────
Route::resource('attendance_types', AttendanceTypeController::class);


// ─── UserController ────────────────────────────────────────────────────────────────────
// Added ->name('users.index') at the end here:
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/update-role/{id}', [UserController::class, 'updateRole'])
->name('users.updateRole');

// ─── 
// CheckAttendance─────────────────────────────────────
Route::get('/check-attendances', [CheckAttendanceController::class, 'index'])
->name('check_attendances.index');
Route::get('/check-attendances/employee/{employee_id}', [CheckAttendanceController::class, 'check'])->name('check_attendances.check');
