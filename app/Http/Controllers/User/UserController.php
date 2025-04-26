<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard(){
        $userId = Auth::id();

        $tickets = Ticket::where('user_id', $userId);

        $notifications = Auth::user()->unreadNotifications;

    return view('client.dashboard', [
        'total' => $tickets->count(),
        'resolved' => (clone $tickets)->where('status', 'resolu')->count(),
        'inProgress' => (clone $tickets)->where('status', 'en_cours')->count(),
        'closed' => (clone $tickets)->where('status', 'ferme')->count(),
        'latestTickets' => (clone $tickets)->orderByDesc('created_at')->take(5)->get(),
        'notifications' => $notifications,
    ]);
    }
}
