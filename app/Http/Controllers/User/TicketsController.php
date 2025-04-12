<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())->get(); // Récupère les tickets du client connecté
        return view('client.tickets.index', compact('tickets'));
    }

    // Afficher le formulaire de création de ticket
    public function create()
    {
        return view('client.tickets.create');
    }

    // Enregistrer un nouveau ticket
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:basse,moyenne,haute', // Exemple de priorités
            'category' => 'required|string|max:255',  // Catégorie de ticket
        ]);

        // Créer le ticket
        Ticket::create([
            'user_id' => Auth::id(), // ID du client connecté
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'category' => $request->category,
            'status' => 'ouvert', // Statut initial
        ]);

        return redirect()->route('client.tickets.index')->with('success', 'Ticket créé avec succès!');
    }

    // Afficher les détails d'un ticket
    public function show($id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id); // Sécuriser avec user_id
        return view('client.tickets.show', compact('ticket'));
    }

    // Ajouter un commentaire au ticket
    public function addComment(Request $request, $ticketId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Trouver le ticket
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($ticketId); // Sécurisation pour que le client ne voie que ses tickets

        // Ajouter un commentaire
        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), // L'utilisateur connecté
            'comment' => $request->comment,
        ]);

        return redirect()->route('client.tickets.show', $ticket->id)->with('success', 'Commentaire ajouté avec succès!');
    }
}

