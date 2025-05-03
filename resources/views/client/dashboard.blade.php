<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate__animated animate__fadeInDown">
            <h2 class="font-extrabold text-2xl text-indigo-700 leading-tight flex items-center">
                <i class="fas fa-user-circle mr-2"></i> {{ __('Espace Client') }}
            </h2>
            <a href="{{ route('client.tickets.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full shadow hover:bg-indigo-700 transition duration-300 animate__animated animate__bounceIn">
                <i class="fas fa-plus mr-1"></i> Nouveau Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-12 animate__animated animate__fadeInUp">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Notifications -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 animate__animated animate__fadeInUp">
                <h3 class="text-xl font-bold mb-4 text-indigo-600 flex items-center">
                    <i class="fas fa-bell mr-2 text-yellow-500"></i> Notifications
                </h3>

                <div id="notifications-list">
                    @if ($notifications->isEmpty())
                        <p class="text-gray-600">Aucune notification pour le moment.</p>
                    @else
                        <ul class="space-y-2">
                            @foreach ($notifications as $notification)
                                <li class="py-2 border-b last:border-none flex justify-between items-center {{ $notification->read_at ? '' : 'font-bold text-indigo-700' }}">
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="hover:underline flex items-center">
                                            @if(!$notification->read_at)
                                                <i class="fas fa-circle text-yellow-400 mr-2"></i>
                                            @else
                                                <i class="fas fa-circle text-gray-300 mr-2"></i>
                                            @endif
                                            {{ $notification->data['message'] ?? 'Notification' }}
                                        </button>
                                    </form>
                                    <span class="text-sm text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="bg-white p-6 rounded-2xl shadow text-center border-t-4 border-indigo-500">
                    <h3 class="text-gray-600">Total</h3>
                    <p class="text-3xl font-extrabold text-indigo-700">{{ $total }}</p>
                </div>
                <div class="bg-blue-100 p-6 rounded-2xl shadow text-center border-t-4 border-blue-500">
                    <h3 class="text-gray-600">Ouverts</h3>
                    <p class="text-3xl font-extrabold text-blue-700">{{ $opened }}</p>
                </div>
                <div class="bg-green-100 p-6 rounded-2xl shadow text-center border-t-4 border-green-500">
                    <h3 class="text-gray-600">Résolus</h3>
                    <p class="text-3xl font-extrabold text-green-700">{{ $resolved }}</p>
                </div>
                <div class="bg-yellow-100 p-6 rounded-2xl shadow text-center border-t-4 border-yellow-500">
                    <h3 class="text-gray-600">En cours</h3>
                    <p class="text-3xl font-extrabold text-yellow-700">{{ $inProgress }}</p>
                </div>
                <div class="bg-red-100 p-6 rounded-2xl shadow text-center border-t-4 border-red-500">
                    <h3 class="text-gray-600">Fermés</h3>
                    <p class="text-3xl font-extrabold text-red-700">{{ $close }}</p>
                </div>
            </div>

            <!-- Graphique des statuts -->
            <div class="bg-white p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp animate__delay-2s">
                <h3 class="text-lg font-semibold mb-4 flex items-center text-indigo-600">
                    <i class="fas fa-chart-pie mr-2"></i> Répartition des tickets par statut
                </h3>
                <canvas id="ticketStatusChart" class="mx-auto w-64 h-64"></canvas>
            </div>

            <!-- Bloc Conseils -->
            <div class="bg-indigo-50 p-6 rounded-2xl shadow animate__animated animate__fadeInUp animate__delay-3s">
                <h3 class="text-lg font-semibold mb-2 text-indigo-700">
                    <i class="fas fa-lightbulb mr-2 text-yellow-400"></i> Conseils pour améliorer vos tickets
                </h3>
                <ul class="list-disc list-inside text-gray-600">
                    <li>Rédigez un titre clair et précis.</li>
                    <li>Ajoutez des captures d'écran pour illustrer votre problème.</li>
                    <li>Suivez l'état du ticket régulièrement depuis votre tableau de bord.</li>
                    <li>Répondez rapidement aux messages des agents pour accélérer la résolution.</li>
                </ul>
            </div>

            <!-- Derniers tickets -->
            <div class="bg-white p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp animate__delay-4s">
                <h3 class="text-lg font-semibold mb-4 flex items-center text-indigo-600">
                    <i class="fas fa-ticket-alt mr-2"></i> Derniers tickets
                </h3>
                @if ($latestTickets->isEmpty())
                    <p class="text-gray-600">Aucun ticket pour le moment.</p>
                @else
                    <table class="w-full text-left border-t">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="py-2 px-2">Titre</th>
                                <th class="py-2 px-2">Statut</th>
                                <th class="py-2 px-2">Date</th>
                                <th class="py-2 px-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestTickets as $ticket)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="py-2 px-2">{{ $ticket->title }}</td>
                                    @php
                                        $statusBg = [
                                            'ouvert' => 'bg-blue-100 text-blue-700',
                                            'en_cours' => 'bg-yellow-100 text-yellow-700',
                                            'resolu' => 'bg-green-100 text-green-700',
                                            'ferme' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp

                                    <td class="py-2 px-2">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusBg[$ticket->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-2">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                    <td class="py-2 px-2">
                                        <a href="{{ route('client.tickets.show', $ticket->id) }}" class="text-indigo-600 hover:underline fw-bolder">
                                             Voir
                                        </a>
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

    <!-- Données JS -->
    <script>
        window.opened = {{ $opened }};
        window.resolved = {{ $resolved }};
        window.inProgress = {{ $inProgress }};
        window.close = {{ $close }};
    </script>

    <!-- Script Chart.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('ticketStatusChart');
            if (ctx && window.Chart) {
                new window.Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Ouverts', 'Résolus', 'En cours', 'Fermés'],
                        datasets: [{
                            data: [window.opened, window.resolved, window.inProgress, window.close],
                            backgroundColor: ['#3B82F6', '#10B981', '#FBBF24', '#EF4444'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                        }]
                    },
                    options: {
                        maintainAspectRatio: true,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#4B5563',
                                    font: { size: 14 }
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
