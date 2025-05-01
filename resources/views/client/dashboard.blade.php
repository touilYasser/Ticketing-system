<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Dashboard') }}
        </h2>
        <a href="{{ route('client.tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
            + Nouveau Ticket
        </a>
    </div>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

             <!-- Notifications -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Notifications</h3>

                <div id="notifications-list">
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

                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white p-6 rounded shadow text-center">
                    <h3 class="text-gray-600">Total</h3>
                    <p class="text-2xl font-bold">{{ $total }}</p>
                </div>
                <div class="bg-blue-100 p-6 rounded shadow text-center">
                    <h3 class="text-gray-600">Ouverts</h3>
                    <p class="text-2xl font-bold">{{ $opened }}</p>
                </div>
                <div class="bg-green-100 p-6 rounded shadow text-center">
                    <h3 class="text-gray-600">Résolus</h3>
                    <p class="text-2xl font-bold">{{ $resolved }}</p>
                </div>
                <div class="bg-yellow-100 p-6 rounded shadow text-center">
                    <h3 class="text-gray-600">En cours</h3>
                    <p class="text-2xl font-bold">{{ $inProgress }}</p>
                </div>
                <div class="bg-red-100 p-6 rounded shadow text-center">
                    <h3 class="text-gray-600">Fermés</h3>
                    <p class="text-2xl font-bold">{{ $close }}</p>
                </div>
            </div>

            <!-- Graphique des statuts -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Répartition des tickets par statut</h3>
                <canvas id="ticketStatusChart" class="mx-auto w-64 h-64"></canvas>
            </div>


           

            <!-- Derniers tickets -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Derniers tickets</h3>
                @if ($latestTickets->isEmpty())
                    <p class="text-gray-600">Aucun ticket pour le moment.</p>
                @else
                    <table class="w-full text-left border-t">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Titre</th>
                                <th class="py-2">Statut</th>
                                <th class="py-2">Date</th>
                                <th class="py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestTickets as $ticket)
                                <tr class="border-b">
                                    <td class="py-2">{{ $ticket->title }}</td>
                                    <td class="py-2 capitalize">
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
                                    <td class="py-2">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                    <td class="py-2">
                                        <a href="{{ route('client.tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline">Voir</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>

    @vite(['resources/js/app.js'])

    <!-- Injection des données dans le JS -->
    <script>
        
        window.opened = {{ $opened }};
        window.resolved = {{ $resolved }};
        window.inProgress = {{ $inProgress }};
        window.close = {{ $close }};
    </script>

    

    <!-- Script du graphique -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('ticketStatusChart');

    if (ctx && window.Chart) {
        new window.Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Ouverts','Résolus', 'En cours', 'Fermés'],
                datasets: [{
                    data: [
                            window.opened,
                            window.resolved,
                            window.inProgress,
                            window.close,
                    ],
                    backgroundColor: [
                        '#3B82F6', // bleu 
                        '#10B981', // vert
                        '#FBBF24', // jaune
                        '#FF0000'  // rouge
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                maintainAspectRatio: true, // permet de garder les proportions
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#4B5563',
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                cutout: '70%',
            }
        });
    }
});
    </script>

</x-app-layout>
