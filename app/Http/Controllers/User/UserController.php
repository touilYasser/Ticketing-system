<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function dashboard() {
        $userId = Auth::id();
    
        // Récupération des tickets pour cet utilisateur
        $tickets = Ticket::where('user_id', $userId);
    
        // Récupération des notifications non lues
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();
        $notifications = $authUser->unreadNotifications()->paginate(5);
    
        // Calcul du nombre de tickets par statut
        $total = $tickets->count();
        $opened = (clone $tickets)->where('status', 'ouvert')->count();
        $resolved = (clone $tickets)->where('status', 'resolu')->count();
        $inProgress = (clone $tickets)->where('status', 'en_cours')->count();
        $close = (clone $tickets)->where('status', 'ferme')->count();
    
        // Vérification des valeurs dans les logs (pour le débogage)
        Log::info("Dashboard data for user $userId - Total: $total, Resolved: $resolved, InProgress: $inProgress, Close: $close");
    
        // Récupération des derniers tickets créés
        $latestTickets = (clone $tickets)->orderByDesc('created_at')->take(5)->get();
    
        // Retourner les données à la vue
        return view('client.dashboard', [
            'total' => $total,
            'opened' => $opened,
            'resolved' => $resolved,
            'inProgress' => $inProgress,
            'close' => $close,
            'latestTickets' => $latestTickets,
            'notifications' => $notifications,
        ]);
    }
}
