<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Agent Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifications -->
            <div class="bg-white p-6 rounded-lg shadow-lg mb-4 transition-transform transform hover:scale-105 duration-300 ease-in-out">
                <h3 class="text-lg font-semibold mb-4">Notifications</h3>
                @if ($notifications->isEmpty())
                    <p class="text-gray-600">Aucune notification pour le moment.</p>
                @else
                    <ul>
                        @foreach ($notifications as $notification)
                            <li class="py-2 {{ $notification->read_at ? '' : 'font-semibold text-blue-600' }}">
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 hover:underline transition duration-300 {{ $notification->read_at ? '' : 'font-bold' }}">
                                        @if(!$notification->read_at)
                                            <i class="fas fa-bell text-yellow-500"></i>
                                        @endif
                                        {{ $notification->data['message'] ?? 'Notification' }}
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>

            <!-- Badge de Performance -->
            @if ($todayResolvedTickets >= 5)
                <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-lg mb-6 animate__animated animate__fadeIn">
                    🏆 Bravo ! Vous avez résolu {{ $todayResolvedTickets }} tickets aujourd'hui !
                </div>
            @endif

            <!-- Historique d’activité -->
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Historique d'activité</h3>
                <ul class="space-y-2">
                    @foreach ($recentComments as $comment)
                        <li class="transition-all duration-300 hover:bg-gray-50 p-2 rounded-md">
                            💬 Vous avez commenté sur le Ticket #{{ $comment->ticket->id }} il y a {{ $comment->created_at->diffForHumans() }}
                        </li>
                    @endforeach
                    @foreach ($recentStatusChanges as $ticket)
                        <li class="transition-all duration-300 hover:bg-gray-50 p-2 rounded-md">
                            🎯 Le statut du Ticket #{{ $ticket->id }} a été modifié récemment à {{ ucfirst($ticket->status) }}.
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Prochaines Échéances -->
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Prochaines échéances</h3>
                <ul class="space-y-2">
                    @foreach ($upcomingDeadlines as $ticket)
                        <li class="transition-all duration-300 hover:bg-gray-50 p-2 rounded-md">
                            📅 Ticket #{{ $ticket->id }} - 
                            @if ($ticket->due_date)
                                À rendre pour <span class="font-bold text-red-600">{{ $ticket->due_date }}</span>
                            @else
                                Date d'échéance non définie
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-xl mb-4">
                @if (session('success'))
                    <div id="success-message" class="message bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 opacity-0 transition-opacity duration-500 ease-out">
                        <strong class="font-bold">Succès!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                @elseif (session('error'))
                    <div id="error-message" class="message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 opacity-0 transition-opacity duration-500 ease-out">
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
                            <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">Filtrer</button>
                        </div>
                    </div>
                </form>

                <!-- Liste des tickets assignés à l'agent -->
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 border-b text-left">Titre</th>
                            <th class="py-3 px-4 border-b text-left">Statut</th>
                            <th class="py-3 px-4 border-b text-left">Priorité</th>
                            <th class="py-3 px-4 border-b text-left">Categorie</th>
                            <th class="py-3 px-4 border-b text-left">Date de création</th>
                            <th class="py-3 px-4 border-b text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr class="transition-all duration-300 hover:bg-gray-50">
                                <td class="py-2 px-4 border-b">{{ $ticket->title }}</td>
                                <td class="px-4 py-2 border-b">
                                    @php
                                        $statusBg = [
                                            'ouvert' => 'bg-blue-100 text-blue-700',
                                            'en_cours' => 'bg-yellow-100 text-yellow-700',
                                            'resolu' => 'bg-green-100 text-green-700',
                                            'ferme' => 'bg-red-100 text-red-700',
                                        ];
                                        $priorityBg = [
                                            'basse' => 'bg-green-100 text-green-700',
                                            'moyenne' => 'bg-yellow-100 text-yellow-700',
                                            'haute' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $statusBg[$ticket->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-2 border-b">
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $priorityBg[$ticket->priority] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b">{{ $ticket->category }}</td>
                                <td class="py-2 px-4 border-b">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-800 transition duration-300 fw-bold">Voir</a>
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
                    fadeIn(successMessage);
                }
                if (errorMessage) {
                    fadeIn(errorMessage);
                }
            }, 300); 
        };

        function fadeIn(element) {
            element.classList.remove('opacity-0');
            element.classList.add('opacity-100');
        }
    </script>
</x-app-layout>
