<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Statistiques -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-blue-600 text-white p-4 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                    <h3 class="text-lg font-semibold">Total des tickets</h3>
                    <p class="text-3xl font-bold mt-2">{{ $ticketCount }}</p>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                    <h3 class="text-lg font-semibold">Tickets ouverts</h3>
                    <p class="text-3xl font-bold mt-2">{{ $openTickets }}</p>
                </div>
                <div class="bg-orange-500 text-white p-4 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                    <h3 class="text-lg font-semibold">En cours</h3>
                    <p class="text-3xl font-bold mt-2">{{ $inProgressTickets }}</p>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                    <h3 class="text-lg font-semibold">Résolus</h3>
                    <p class="text-3xl font-bold mt-2">{{ $resolvedTickets }}</p>
                </div>
                <div class="bg-red-500 text-white p-4 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                    <h3 class="text-lg font-semibold">Fermés</h3>
                    <p class="text-3xl font-bold mt-2">{{ $closedTickets }}</p>
                </div>
            </div>

            <!-- Liste des tickets -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Tickets</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Titre</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Statut</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Agent assigné</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $statusColors = [
                                    'ouvert' => 'bg-blue-100 text-blue-700',
                                    'en_cours' => 'bg-yellow-100 text-yellow-700',
                                    'resolu' => 'bg-green-100 text-green-700',
                                    'ferme' => 'bg-red-100 text-red-700',
                                ];
                            @endphp

                            @forelse($tickets as $ticket)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $ticket->title }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($ticket->agent)
                                            <span class="text-gray-700">{{ $ticket->agent->name }}</span>
                                        @else
                                            <form method="POST" action="{{ route('admin.tickets.assignAgent', $ticket->id) }}" class="flex items-center space-x-2">
                                                @csrf
                                                <select name="agent_id" class="border-gray-300 rounded px-2 py-1 text-sm focus:ring focus:ring-blue-300" required>
                                                    <option value="">Choisir un agent</option>
                                                    @foreach($agents as $agent)
                                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700 transition">
                                                    Assigner
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline text-sm font-semibold transition">
                                            Voir
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center px-4 py-4 text-red-600">Aucun ticket disponible</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
