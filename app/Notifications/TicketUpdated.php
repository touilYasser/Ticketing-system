<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\Log;

class TicketUpdated extends Notification
{
    use Queueable;

    protected $ticket;
    protected $message;

    public function __construct($ticket, $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database']; // Très important, pour stocker dans la base
    }

    public function toDatabase($notifiable)
{
    Log::info('Notification envoyée à : ' . $notifiable->email);  // Ajoute un log pour vérifier l'utilisateur

    return [
        'message' => $this->message,
        'url' => route('client.tickets.show', $this->ticket->id),
    ];
}
}