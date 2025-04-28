<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAsRead($id)
{
    $notification = DatabaseNotification::findOrFail($id); // 🔥 récupère correctement

    if ($notification->notifiable_id == Auth::id()) { // 🔥 sécurité : vérifier que c'est bien sa notification
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $redirectUrl = $notification->data['url'] ?? '/dashboard';
        return redirect($redirectUrl);
    } else {
        abort(403, 'Non autorisé.');
    }
}
}
