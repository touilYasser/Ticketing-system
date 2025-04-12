<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <table class="w-full table-auto border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">Titre</th>
                            <th class="px-4 py-2 border border-gray-300">Statut</th>
                            <th class="px-4 py-2 border border-gray-300">Priorité</th>
                            <th class="px-4 py-2 border border-gray-300">Catégorie</th>
                            <th class="px-4 py-2 border border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="px-4 py-2 border border-gray-300">{{ $ticket->title }}</td>
                                <td class="px-4 py-2 border">
                                    <span class="
                                        @if ($ticket->status == 'ouvert') 
                                            text-primary fw-bolder 
                                        @elseif ($ticket->status == 'en_cours') 
                                            text-warning fw-bolder 
                                        @elseif ($ticket->status == 'resolu') 
                                            text-success fw-bolder 
                                        @else 
                                            text-danger fw-bolder 
                                        @endif
                                    ">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border">
                                    <span class="
                                        @if ($ticket->priority == 'basse') 
                                            text-success fw-bolder 
                                        @elseif ($ticket->priority == 'moyenne') 
                                            text-warning fw-bolder 
                                        @else 
                                            text-danger fw-bolder 
                                        @endif
                                    ">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border border-gray-300">{{ $ticket->category }}</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <a href="{{ route('client.tickets.show', $ticket->id) }}" class="text-blue-600 fw-bolder hover:underline">Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center px-4 py-2 text-red-600">Aucun ticket disponible</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
