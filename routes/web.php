<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\User\TicketsController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// client routes
Route::prefix('client')->middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('client.dashboard');

    Route::get('/tickets', [TicketsController::class, 'index'])->name('client.tickets.index');
    Route::get('/tickets/create', [TicketsController::class, 'create'])->name('client.tickets.create');
    Route::post('/tickets', [TicketsController::class, 'store'])->name('client.tickets.store');
    Route::get('/tickets/{ticket}', [TicketsController::class, 'show'])->name('client.tickets.show');

    Route::post('/tickets/{ticket}/comments', [TicketsController::class, 'addComment'])->name('client.tickets.addComment');

    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});



// admin routes
Route::prefix('admin')->middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::post('/tickets/{ticket}/assign-agent', [AdminController::class, 'assignAgent'])->name('admin.tickets.assignAgent');
    Route::get('/tickets/{ticket}', [AdminController::class, 'show'])->name('admin.tickets.show');
    Route::get('/tickets/{ticket}/edit', [AdminController::class, 'edit'])->name('admin.tickets.edit');
    Route::put('/tickets/{ticket}', [AdminController::class, 'update'])->name('admin.tickets.update');
    Route::delete('/tickets/{ticket}', [AdminController::class, 'destroy'])->name('admin.tickets.destroy');
    
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

});



// agent routes
Route::middleware(['auth', 'agentMiddleware'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');

    Route::get('/agent/tickets/{ticket}', [AgentController::class, 'show'])->name('agent.tickets.show');
    Route::put('/agent/tickets/{ticket}', [AgentController::class, 'update'])->name('agent.tickets.update');
    
    Route::post('/agent/tickets/{ticket}/comment', [AgentController::class, 'comment'])->name('agent.tickets.comment');

    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

require __DIR__.'/auth.php';
