<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agent Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifications -->
            <div class="bg-white p-6 rounded shadow mb-3">
                <h3 class="text-lg font-semibold mb-4">Notifications</h3>
                @if ($notifications->isEmpty())
                    <p class="text-gray-600">Aucune notification pour le moment.</p>
                @else
                <ul>
                    @foreach ($notifications as $notification)
                        <li class="py-2 {{ $notification->read_at ? '' : 'font-bold' }}">
                            <!-- Lien vers l'action de lecture de la notification -->
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:underline {{ $notification->read_at ? '' : 'font-bold' }}">
                                    @if(!$notification->read_at)
                                        <i class="fas fa-bell text-yellow-500"></i>
                                    @endif
                                    {{ $notification->data['message'] ?? 'Notification' }}
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                    <!-- Ajouter la pagination si nécessaire -->
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>

            <!-- Badge de Performance -->
            @if ($todayResolvedTickets >= 5)
                <div class="bg-green-100 text-green-800 p-4 rounded shadow mb-6">
                    🏆 Bravo ! Vous avez résolu {{ $todayResolvedTickets }} tickets aujourd'hui !
                </div>
            @endif

            <!-- Historique d’activité -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Historique d'activité</h3>
                <ul class="space-y-2">
                    @foreach ($recentComments as $comment)
                        <li>
                            💬 Vous avez commenté sur le Ticket #{{ $comment->ticket->id }}
                            il y a {{ $comment->created_at->diffForHumans() }}
                        </li>
                    @endforeach
                    @foreach ($recentStatusChanges as $ticket)
                        <li>🎯 Le statut du Ticket #{{ $ticket->id }} a été modifié récemment à {{ ucfirst($ticket->status) }}.</li>
                    @endforeach
                </ul>
            </div>

            <!-- Prochaines Échéances -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Prochaines échéances</h3>
                <ul class="space-y-2">
                    @foreach ($upcomingDeadlines as $ticket)
                        <li>📅 Ticket #{{ $ticket->id }} - 
                            @if ($ticket->due_date)
                                À rendre pour <span class="text-danger fw-bold">{{ $ticket->due_date }}</span>
                            @else
                                Date d'échéance non définie
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div id="success-message" class="message bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <strong class="font-bold">Succès!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                @elseif (session('error'))
                    <div id="error-message" class="message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong class="font-bold">Erreur!</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Formulaire de filtre -->
                <form method="GET" action="{{ route('agent.dashboard') }}" class="mb-4">
                    <div class="flex space-x-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="status" id="status" class="mt-1 block w-full">
                                <option value="">Tous</option>
                                <option value="ouvert" {{ request('status') == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                                <option value="en_cours" {{ request('status') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="resolu" {{ request('status') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                            </select>
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Priorité</label>
                            <select name="priority" id="priority" class="mt-1 block w-full">
                                <option value="">Toutes</option>
                                <option value="basse" {{ request('priority') == 'basse' ? 'selected' : '' }}>Basse</option>
                                <option value="moyenne" {{ request('priority') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="haute" {{ request('priority') == 'haute' ? 'selected' : '' }}>Haute</option>
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Filtrer</button>
                        </div>
                    </div>
                </form>

                <!-- Liste des tickets assignés à l'agent -->
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Titre</th>
                            <th class="py-2 px-4 border-b text-left">Statut</th>
                            <th class="py-2 px-4 border-b text-left">Priorité</th>
                            <th class="py-2 px-4 border-b text-left">Categorie</th>
                            <th class="py-2 px-4 border-b text-left">Date de création</th>
                            <th class="py-2 px-4 border-b text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $ticket->title }}</td>
                                <td class="px-4 py-2 border-b">
                                    <span class="
                                        @if ($ticket->status == 'ouvert') text-primary fw-bolder
                                        @elseif ($ticket->status == 'en_cours') text-warning fw-bolder
                                        @elseif ($ticket->status == 'resolu') text-success fw-bolder
                                        @else text-danger fw-bolder
                                        @endif
                                    ">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                    
                                <td class="px-4 py-2 border-b">
                                    <span class="
                                        @if ($ticket->priority == 'basse') text-success fw-bolder
                                        @elseif ($ticket->priority == 'moyenne') text-warning fw-bolder
                                        @else text-danger fw-bolder
                                        @endif
                                    ">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b">{{ $ticket->category }}</td>
                                <td class="py-2 px-4 border-b">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-800">Voir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                var successMessage = document.getElementById('success-message');
                var errorMessage = document.getElementById('error-message');
                
                if (successMessage) {
                    fadeOut(successMessage);
                }
                if (errorMessage) {
                    fadeOut(errorMessage);
                }
            }, 1300); 
        };

        function fadeOut(element) {
            element.style.transition = "opacity 2s ease";
            element.style.opacity = 0;
            setTimeout(function() {
                element.style.display = "none";
            }, 2000);
        }
    </script>
</x-app-layout>
