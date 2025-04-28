<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">{{ $ticket->title }}</h3>
                <p>{{ $ticket->description }}</p>

                <h4 class="mt-4">Commentaires :</h4>
                <ul>
                    @foreach($ticket->comments as $comment)
                        <li>
                            <strong>{{ $comment->user->name }} :</strong> {{ $comment->content }}
                        </li>
                    @endforeach
                </ul>

                <h4 class="mt-4">Pièces jointes :</h4>
                <ul>
                    @foreach($ticket->attachments as $attachment)
                        <li>
                            <a href="{{ Storage::url($attachment->file_path) }}" class="text-blue-600" download>{{ $attachment->file_name }}</a>
                        </li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('agent.tickets.comment', $ticket->id) }}">
                    @csrf
                    <div class="mt-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Ajouter un commentaire</label>
                        <textarea name="content" id="content" rows="4" class="mt-1 block w-full" required></textarea>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Ajouter le commentaire</button>
                </form>

                <form method="POST" action="{{ route('agent.tickets.update', $ticket->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mt-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="status" id="status" class="mt-1 block w-full">
                            <option value="en_cours" {{ $ticket->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="resolu" {{ $ticket->status == 'resolu' ? 'selected' : '' }}>Resolu</option>
                            <option value="ouvert" {{ $ticket->status == 'ouvert' ? 'selected' : '' }}>ouvert</option>
                            <option value="ferme" {{ $ticket->status == 'ferme' ? 'selected' : '' }}>Ferme</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Mettre à jour le statut</button>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>
