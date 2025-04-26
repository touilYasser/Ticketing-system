<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Notifications\TicketUpdated;


class AgentController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les tickets assignés à l'agent connecté
        $tickets = Ticket::where('agent_id', Auth::id())
            ->when($request->has('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->has('priority'), function ($query) use ($request) {
                return $query->where('priority', $request->priority);
            })
            ->paginate(10); // Pagination des tickets
        
        $notifications = Auth::user()->unreadNotifications;

        return view('agent.dashboard', compact('tickets','notifications'));
    }

    public function show($id)
    {
        $ticket = Ticket::with(['comments.user', 'attachments'])->findOrFail($id);

        return view('agent.tickets.show', compact('ticket'));
    }

    public function update(Request $request, $ticketId)
    {
        $request->validate([
            'status' => 'required|string|in:ouvert,en_cours,resolu,ferme',
        ]);

        $ticket = Ticket::findOrFail($ticketId);
        $ticket->status = $request->status; 

        $ticket->save();

        if ($ticket->user) {
            $ticket->user->notify(new TicketUpdated($ticket, 'Le statut de votre ticket a été changé à "' . $request->status . '".'));
        }


        return redirect()->route('agent.dashboard', $ticketId)->with('success', 'Ticket mis à jour avec succès.');
    }

    public function comment(Request $request, $ticketId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $ticket = Ticket::findOrFail($ticketId);

        $ticket->comments()->create([
            'user_id' => Auth::id(), // ID de l'agent connecté
            'comment' => $request->comment,
        ]);

        if ($ticket->user) {
            $ticket->user->notify(new TicketUpdated($ticket, 'Un agent a répondu à votre ticket.'));
        }


        return redirect()->route('agent.tickets.show', $ticketId)->with('success', 'Commentaire ajouté avec succès.');
    }


}
