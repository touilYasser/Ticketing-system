<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    public function index(Request $request)
{
    $ticketsQuery = Ticket::with('attachments')
        ->where('user_id', Auth::id())
        ->when($request->status, fn($q) => $q->where('status', $request->status))
        ->when($request->priority, fn($q) => $q->where('priority', $request->priority))
        ->when($request->category, fn($q) => $q->where('category', $request->category))
        ->latest();

    $tickets = $ticketsQuery->paginate(10);

    $categories = Ticket::where('user_id', Auth::id())->distinct()->pluck('category');

    return view('client.tickets.index', compact('tickets', 'categories'));
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
        'attachments' => 'nullable|array',
        'attachments.*' => 'nullable|file|max:2048',
    ]);

    $ticket = Ticket::create([
        'user_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
        'status' => 'ouvert',
    ]);

    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $path = $file->store('attachments', 'public');

            $ticket->attachments()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'user_id' => Auth::id(),
            ]);
        }
    }

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
            'content' => 'required|string',
        ]);

        // Trouver le ticket
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($ticketId); // Sécurisation pour que le client ne voie que ses tickets

        // Ajouter un commentaire
        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), // L'utilisateur connecté
            'content' => $request->content,
        ]);

        return redirect()->route('client.tickets.show', $ticket->id)->with('success', 'Commentaire ajouté avec succès!');
    }
}

