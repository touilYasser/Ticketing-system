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
                                <a href="{{ $notification->data['url'] }}" class="text-blue-600 hover:underline">
                                    {{ $notification->data['message'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
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
                                <td class="py-2 px-4 border-b">{{ ucfirst($ticket->status) }}</td>
                                <td class="py-2 px-4 border-b">{{ ucfirst($ticket->priority) }}</td>
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
            element.style.transition = "opacity 2s ease-out";
            element.style.opacity = 0;
            setTimeout(function() {
                element.style.display = 'none';
            }, 1300);
        }
    </script>
</x-app-layout>
