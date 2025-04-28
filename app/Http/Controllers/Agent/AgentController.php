<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


use App\Notifications\TicketUpdated;
use Carbon\Carbon;

class AgentController extends Controller
{
    public function index(Request $request)
{
    // Récupérer les tickets pour l'agent connecté avec les filtres de statut et priorité
    $tickets = Ticket::where('agent_id', Auth::id())
        ->when($request->has('status'), function ($query) use ($request) {
            return $query->where('status', $request->status);
        })
        ->when($request->has('priority'), function ($query) use ($request) {
            return $query->where('priority', $request->priority);
        })
        // Charger les commentaires associés aux tickets, triés par date de création
        ->with(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Trier les commentaires par date de création
        }])
        // Trier les tickets par date de création
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Notifications non lues pour l'utilisateur connecté
    $notifications = Auth::user()->unreadNotifications()->paginate(5);

    // Historique des actions récentes (les commentaires faits par l'agent connecté)
    $recentComments = Comment::where('user_id', Auth::id())
        ->latest('created_at') // Trier par date de création des commentaires
        ->take(5)
        ->get();

    // Nombre de tickets résolus aujourd'hui
    $todayResolvedTickets = Ticket::where('agent_id', Auth::id())
        ->where('status', 'resolu')
        ->whereDate('updated_at', Carbon::today())
        ->count();

    // Prochaines échéances (tickets assignés à l'agent avec une date d'échéance)
    $upcomingDeadlines = Ticket::where('agent_id', Auth::id())
        ->whereNotNull('due_date')
        ->whereDate('due_date', '>=', now())
        ->orderBy('due_date')
        ->take(5)
        ->get();

    // Historique des modifications de statut récentes
    $recentStatusChanges = Ticket::where('agent_id', Auth::id())
    ->whereNotNull('status')
    ->orderBy('updated_at', 'desc')
    ->take(5)
    ->get();

    return view('agent.dashboard', compact(
        'tickets', 
        'notifications', 
        'recentComments', 
        'todayResolvedTickets', 
        'upcomingDeadlines',
        'recentStatusChanges'
    ));
}

    public function show($id)
    {
        $ticket = Ticket::with(['comments.user', 'attachments'])->findOrFail($id);

        return view('agent.tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
{
    $validated = $request->validate([
        'status' => 'required|string|in:ouvert,en_cours,resolu,ferme',
    ]);

    $ticket->update([
        'status' => $validated['status'],
    ]);

    if ($ticket->client) {
        Log::info('Envoi de notification au client : ' . $ticket->client->email);
        $ticket->client->notify(new TicketUpdated($ticket, 'Le statut de votre ticket ' . $ticket->id . ' a été changé à "' . ucfirst($validated['status']) . '".'));
    } else {
        Log::error('Aucun client associé au ticket ID : ' . $ticket->id);
    }

    return redirect()->route('agent.dashboard')->with('success', 'Ticket mis à jour avec succès.');
}

    public function comment(Request $request, $ticketId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $ticket = Ticket::findOrFail($ticketId);

        $ticket->comments()->create([
            'user_id' => Auth::id(), // ID de l'agent connecté
            'content' => $request->content,
        ]);

        if ($ticket->client) {
            $ticket->client->notify(new TicketUpdated($ticket, 'Un agent a répondu à votre ticket.'));
        }
        

        return redirect()->route('agent.tickets.show', $ticketId)->with('success', 'Commentaire ajouté avec succès.');
    }


}
