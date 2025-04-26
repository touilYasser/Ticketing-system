<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TicketUpdated extends Notification
{
    public $ticket;
    public $message;

    public function __construct($ticket, $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database']; // tu peux ajouter 'mail' si tu veux
    }

    public function toDatabase($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'message' => $this->message,
            'url' => route('client.tickets.show', $this->ticket->id),
        ];
    }
}
