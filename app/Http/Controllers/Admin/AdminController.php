<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketUpdated;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index()
{
    // Récupérer tous les tickets (ou selon des critères)
    $tickets = Ticket::all();

    // Récupérer tous les agents
    $agents = User::where('role', 'agent')->get();

    // Calculer d'autres données nécessaires pour le tableau de bord
    $ticketCount = Ticket::count();
    $openTickets = Ticket::where('status', 'ouvert')->count();
    $inProgressTickets = Ticket::where('status', 'en_cours')->count();
    $resolvedTickets = Ticket::where('status', 'resolu')->count();
    $closedTickets = Ticket::where('status', 'ferme')->count();

    return view('admin.dashboard', compact('tickets', 'agents', 'ticketCount', 'openTickets', 'inProgressTickets', 'resolvedTickets','closedTickets'));
}

public function assignAgent(Request $request, Ticket $ticket)
{
    $request->validate([
        'agent_id' => 'required|exists:users,id', // Assurer que l'agent existe dans la table users
    ]);

    $ticket->agent_id = $request->agent_id; // Assigner l'agent au ticket

    // Définir la date d'échéance si elle est vide
    if (is_null($ticket->due_date)) {
        $ticket->due_date = now()->addWeek();  // Ajouter 7 jours à la date actuelle
    }

    $ticket->save();

    return redirect()->route('admin.dashboard', $ticket->id)
                     ->with('success', 'Agent assigné avec succès');
}

public function show($id)
{
    $ticket = Ticket::with(['attachments', 'comments.user', 'agent'])->findOrFail($id);

    $agents = User::where('role', 'agent')->get();

    return view('admin.tickets.show', compact('ticket', 'agents'));
}

public function edit(Ticket $ticket)
{
    return view('admin.tickets.edit', compact('ticket'));
}

// Mettre à jour un ticket
public function update(Request $request, Ticket $ticket)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string|in:ouvert,en_cours,resolu,ferme',
        'priority' => 'required|string|in:basse,moyenne,haute',
        'category' => 'required|string|max:255',
    ]);

    $ticket->update($validated);

    $message = 'Le statut de votre ticket ' . $ticket->id .' a été mis à jour par un administrateur.';

    // 🔔 Notifier le client
    if ($ticket->client) {
        $ticket->client->notify(new TicketUpdated($ticket, $message));
    }

    // 🔔 Notifier l'agent assigné
    if ($ticket->agent) {
        $ticket->agent->notify(new TicketUpdated($ticket, $message));
    }

    return redirect()->route('admin.tickets.show', $ticket->id)
        ->with('success', 'Ticket mis à jour avec succès.');
}

public function destroy(Ticket $ticket)
{
    // Supprimer le ticket
    $ticket->delete();

    // Rediriger avec un message de succès
    return redirect()->route('admin.dashboard')->with('success', 'Ticket supprimé avec succès.');
}

public function usersIndex()
{
    $users = User::all(); // Tu peux éventuellement ajouter un paginage avec `paginate()`
    return view('admin.users.index', compact('users'));
}

public function createUser()
{
    return view('admin.users.create');
}

public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'role' => 'required|in:client,agent,admin', // Validation du rôle
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès!');
}

public function editUser($id)
{
    $user = User::findOrFail($id);
    return view('admin.users.edit', compact('user'));
}

public function updateUser(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|in:client,agent,admin',
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès!');
}

public function destroyUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès!');
}




}
