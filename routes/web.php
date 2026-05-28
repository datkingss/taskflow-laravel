<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    // Route cập nhật công việc
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

    // Route xóa tất cả công việc theo trạng thái
    Route::delete('/tasks/clear-status', [TaskController::class, 'clearStatus'])->name('tasks.clearStatus');

    // Route xóa công việc
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    // Route xem toàn bộ bảng Kanban
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    // Route cho Thông báo
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    // Khối Routes quản lý Nhóm nâng cao
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::post('/teams/join', [TeamController::class, 'requestToJoin'])->name('teams.join');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    
    Route::post('/teams/{team}/invite', [TeamController::class, 'inviteMember'])->name('teams.invite');
    Route::post('/teams/{team}/accept', [TeamController::class, 'acceptInvite'])->name('teams.accept');
    Route::delete('/teams/{team}/remove/{user}', [TeamController::class, 'removeMember'])->name('teams.remove');
    Route::post('/teams/{team}/approve/{user}', [TeamController::class, 'approveRequest'])->name('teams.approve');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'exportCsv'])->name('reports.export');

    // Các routes dành riêng cho Quản trị viên (Admin)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
    });
    });
    
require __DIR__.'/auth.php';
