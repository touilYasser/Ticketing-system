<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Statistiques du tableau de bord -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="bg-blue-600 text-white p-4 rounded">
                        <h3 class="text-lg font-semibold">Total des tickets</h3>
                        <p>{{ $ticketCount }}</p>
                    </div>
                    <div class="bg-yellow-600 text-white p-4 rounded">
                        <h3 class="text-lg font-semibold">Tickets ouverts</h3>
                        <p>{{ $openTickets }}</p>
                    </div>
                    <div class="bg-orange-600 text-white p-4 rounded">
                        <h3 class="text-lg font-semibold">Tickets en cours</h3>
                        <p>{{ $inProgressTickets }}</p>
                    </div>
                    <div class="bg-green-600 text-white p-4 rounded">
                        <h3 class="text-lg font-semibold">Tickets résolus</h3>
                        <p>{{ $resolvedTickets }}</p>
                    </div>
                    <div class="bg-red-600 text-white p-4 rounded">
                        <h3 class="text-lg font-semibold">Tickets fermes</h3>
                        <p>{{ $resolvedTickets }}</p>
                    </div>
                </div>

                <!-- Liste des tickets avec assignation d'agent -->
                <h3 class="mt-8 text-2xl font-semibold">Tickets</h3>
                <table class="w-full table-auto border border-gray-300 mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">Titre</th>
                            <th class="px-4 py-2 border border-gray-300">Statut</th>
                            <th class="px-4 py-2 border border-gray-300">Agent assigné</th>
                            <th class="px-4 py-2 border border-gray-300">Action</th>
                        </tr>
                    </thead>
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
                                <td class="px-4 py-2 border border-gray-300">
                                    @if ($ticket->agent)
                                        {{ $ticket->agent->name }}
                                    @else
                                        <form method="POST" action="{{ route('admin.tickets.assignAgent', $ticket->id) }}">
                                            @csrf
                                            <select name="agent_id" class="border-gray-300 rounded" required>
                                                <option value="">Choisir un agent</option>
                                                @foreach($agents as $agent)
                                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Assigner</button>
                                        </form>
                                    @endif
                                </td>
                                
                                <td class="px-4 py-2 border border-gray-300">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline fw-bolder">Voir</a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-2 text-red-600">Aucun ticket disponible</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

