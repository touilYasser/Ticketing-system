<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\TicketsController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// client routes
Route::middleware(['auth', 'userMiddleware'])->group(function () {

    // dashboard
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');

    // tickets
    Route::get('/tickets', [TicketsController::class, 'index'])->name('client.tickets.index');
    Route::get('/tickets/create', [TicketsController::class, 'create'])->name('client.tickets.create');
    Route::post('/tickets', [TicketsController::class, 'store'])->name('client.tickets.store');
    Route::get('/tickets/{ticket}', [TicketsController::class, 'show'])->name('client.tickets.show');

    // Route pour ajouter un commentaire à un ticket
    Route::post('/tickets/{ticket}/comments', [TicketsController::class, 'addComment'])->name('client.tickets.addComment');
});


// admin routes
Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


// agent routes
Route::middleware(['auth', 'agentMiddleware'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
});

require __DIR__.'/auth.php';
