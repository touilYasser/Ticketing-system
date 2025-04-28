<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes tickets') }}
            </h2>
            <a href="{{ route('client.tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                + Nouveau Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

                <table class="w-full table-auto border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">Titre</th>
                            <th class="px-4 py-2 border border-gray-300">Statut</th>
                            <th class="px-4 py-2 border border-gray-300">Priorité</th>
                            <th class="px-4 py-2 border border-gray-300">Catégorie</th>
                            <th class="px-4 py-2 border border-gray-300">Fichier(s)</th>
                            <th class="px-4 py-2 border border-gray-300">Agent</th>
                            <th class="px-4 py-2 border border-gray-300">Action</th>
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau -->
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="px-4 py-2 border border-gray-300">{{ $ticket->title }}</td>
                    
                                <td class="px-4 py-2 border">
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
                    
                                <td class="px-4 py-2 border">
                                    <span class="
                                        @if ($ticket->priority == 'basse') text-success fw-bolder
                                        @elseif ($ticket->priority == 'moyenne') text-warning fw-bolder
                                        @else text-danger fw-bolder
                                        @endif
                                    ">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                    
                                <td class="px-4 py-2 border border-gray-300">{{ $ticket->category }}</td>

                                <td class="px-4 py-2 border text-center">
                                    @if($ticket->attachments->count())
                                    ✅
                                    @else
                                        —
                                    @endif
                                </td>
                    
                                <!-- Colonne agent -->
                                <td class="px-4 py-2 border border-gray-300">
                                    @if($ticket->agent)
                                        {{ $ticket->agent->name }}
                                    @else
                                        <span class="text-gray-500 italic">Aucun agent assigné</span>
                                    @endif
                                </td>
                    
                                <td class="px-4 py-2 border border-gray-300">
                                    <a href="{{ route('client.tickets.show', $ticket->id) }}" class="text-blue-600 fw-bolder hover:underline">Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center px-4 py-2 text-red-600">Aucun ticket disponible</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $tickets->withQueryString()->links() }}
                </div>

                <!-- Filtres -->
                <form method="GET" action="{{ route('client.tickets.index') }}" class="mb-6 flex flex-wrap mt-4 gap-4 items-center">

                    <!-- Statut -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="status" id="status" class="form-select mt-1 block w-full">
                            <option value="">Tous</option>
                            <option value="ouvert" {{ request('status') == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                            <option value="en_cours" {{ request('status') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="resolu" {{ request('status') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                        </select>
                    </div>
                
                    <!-- Priorité -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priorité</label>
                        <select name="priority" id="priority" class="form-select mt-1 block w-full">
                            <option value="">Toutes</option>
                            <option value="basse" {{ request('priority') == 'basse' ? 'selected' : '' }}>Basse</option>
                            <option value="moyenne" {{ request('priority') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="haute" {{ request('priority') == 'haute' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>
                
                    <!-- Catégorie -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="category" id="category" class="form-select mt-1 block w-full">
                            <option value="" selected>Toutes</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- Bouton -->
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Filtrer</button>
                    </div>
                </form>
                
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
