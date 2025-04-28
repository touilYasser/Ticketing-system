<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Affichage des informations du ticket -->
                <div>
                    <h3 class="text-2xl font-semibold">{{ $ticket->title }}</h3>
                    <p>{{ $ticket->description }}</p>
                    <p>
                        <strong>Statut:</strong>
                        <span class="
                            @if ($ticket->status === 'ouvert') text-success
                            @elseif ($ticket->status === 'en cours') text-warning
                            @elseif ($ticket->status === 'fermé') text-danger
                            @else text-gray-600 @endif
                        ">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </p>
                    
                    <p>
                        <strong>Priorité:</strong>
                        <span class="
                            @if ($ticket->priority === 'haute') text-danger
                            @elseif ($ticket->priority === 'moyenne') text-warning
                            @elseif ($ticket->priority === 'basse') text-primary
                            @else text-gray-700 @endif
                        ">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </p>
                    
                    <p><strong>Catégorie:</strong> {{ $ticket->category }}</p>
                </div>

                <!-- Affichage de la date d'échéance -->
                <div class="mt-4 flex items-center">
                    <h4 class="font-medium mr-2">Date d'échéance:</h4>
                    @if ($ticket->due_date)
                        <span class="text-danger fw-bold">{{ $ticket->due_date }}</span>
                    @else
                        <span>Aucune date d'échéance définie.</span>
                    @endif
                </div>

                <!-- Agent assigné -->
                <div class="mt-4">
                    <h4 class="font-medium">Agent assigné:</h4>
                    @if ($ticket->agent)
                        <p>{{ $ticket->agent->name }}</p>
                    @else
                        <p>Aucun agent assigné.</p>
                    @endif
                </div>

                <!-- Formulaire pour assigner un agent -->
                <div class="mt-6">
                    <h4 class="font-medium">Assigner un agent</h4>
                    <form action="{{ route('admin.tickets.assignAgent', $ticket->id) }}" method="POST">
                        @csrf
                        <select name="agent_id" class="form-select mt-1 block w-full">
                            <option value="">Sélectionner un agent</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $ticket->agent_id == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 text-white mt-4 px-4 py-2 rounded">Assigner</button>
                    </form>
                </div>

                <!-- Commentaires et pièces jointes -->
                <div class="mt-6">
                    <h4 class="font-medium">Commentaires</h4>
                    <ul>
                        @foreach ($ticket->comments as $comment)
                            <li>{{ $comment->user->name }}: {{ $comment->content }}</li>
                        @endforeach
                    </ul>

                    <h4 class="mt-4 font-medium">Pièces jointes</h4>
                    <ul class="list-disc list-inside space-y-1 text-blue-600">
                        @forelse ($ticket->attachments as $attachment)
                            <li>
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="hover:underline">
                                    {{ basename($attachment->file_path) }}
                                </a>
                            </li>
                        @empty
                            <li class="text-gray-500">Aucune pièce jointe.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="mt-2 flex space-x-4">
                    <!-- Bouton pour supprimer le ticket -->
                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">Supprimer le ticket</button>
                    </form>
                
                    <!-- Lien pour modifier le ticket -->
                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Modifier ce ticket</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
