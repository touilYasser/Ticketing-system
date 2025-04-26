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

                    <!-- agent assigne -->
                    <div class="flex items-center space-x-4">
                        <h4 class="font-medium">Agent assigné :</h4>
                        <p>
                            @if ($ticket->agent)
                                {{ $ticket->agent->name }}
                            @else
                                <span class="text-gray-500 italic">Aucun agent assigné</span>
                            @endif
                        </p>
                    </div>

                    <!-- Pièces jointes -->
                    @if ($ticket->attachments->count())
                    <div>
                        <h4 class="font-medium">Pièces jointes :</h4>
                        <ul class="list-disc list-inside text-blue-600 space-y-1">
                            @foreach ($ticket->attachments as $attachment)
                                <li>
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" 
                                    target="_blank" 
                                    class="hover:underline" 
                                    download>
                                        📄 Télécharger {{ basename($attachment->file_path) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @else
                    <div>
                        <h4 class="font-medium">Pièces jointes :</h4>
                        <p class="text-gray-500">Aucune pièce jointe disponible.</p>
                    </div>
                    @endif

                    

                    <!-- Commentaires et ajout -->
                    <div>
                        <h4 class="font-medium">Commentaires :</h4>
                        <ul class="space-y-4">
                            @foreach ($ticket->comments as $comment)
                                <li class="flex items-start bg-gray-50 border border-gray-200 rounded-xl p-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center font-bold text-lg">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4 w-full">
                                        <div class="flex justify-between items-center">
                                            <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-2 text-gray-700 leading-relaxed">
                                            {{ $comment->content }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                        

                        <!-- Formulaire pour ajouter un commentaire -->
                        <form method="POST" action="{{ route('client.tickets.addComment', $ticket->id) }}">
                            @csrf
                            <div class="mt-4">
                                <textarea name="content" class="w-full border rounded p-2" rows="4" placeholder="Ajoutez un commentaire..."></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter un commentaire</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
