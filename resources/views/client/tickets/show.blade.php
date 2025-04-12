<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="space-y-4">
                    <!-- Titre du ticket -->
                    <div>
                        <h3 class="text-2xl font-semibold">{{ $ticket->title }}</h3>
                        <p class="text-gray-600">{{ $ticket->description }}</p>
                    </div>

                    <!-- Statut du ticket -->
                    <div class="flex items-center space-x-4">
                        <h4 class="font-medium w-24">Statut :</h4>
                        <p class="
                            @if ($ticket->status == 'ouvert') 
                                text-primary fw-bold 
                            @elseif ($ticket->status == 'en_cours') 
                                text-warning fw-bold 
                            @elseif ($ticket->status == 'resolu') 
                                text-success fw-bold 
                            @else 
                                text-danger fw-bold 
                            @endif
                        ">
                            {{ ucfirst($ticket->status) }}
                        </p>
                    </div>

                    <!-- Priorité du ticket -->
                    <div class="flex items-center space-x-4">
                        <h4 class="font-medium w-24">Priorité :</h4>
                        <p class="
                            @if ($ticket->priority == 'basse') 
                                text-success fw-bold 
                            @elseif ($ticket->priority == 'moyenne') 
                                text-warning fw-bold 
                            @else 
                                text-danger fw-bold 
                            @endif
                        ">
                            {{ ucfirst($ticket->priority) }}
                        </p>
                    </div>

                    <!-- Catégorie du ticket -->
                    <div class="flex items-center space-x-4">
                        <h4 class="font-medium w-24">Catégorie :</h4>
                        <p>{{ $ticket->category }}</p>
                    </div>

                    <!-- Commentaires et ajout -->
                    <div>
                        <h4 class="font-medium">Commentaires :</h4>
                        <ul>
                            @foreach ($ticket->comments as $comment)
                                <li class="bg-gray-100 p-4 rounded-lg mb-2">
                                    <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}</p>
                                    <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Formulaire pour ajouter un commentaire -->
                        <form method="POST" action="{{ route('client.tickets.addComment', $ticket->id) }}">
                            @csrf
                            <div class="mt-4">
                                <textarea name="comment" class="w-full border rounded p-2" rows="4" placeholder="Ajoutez un commentaire..."></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter un commentaire</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
