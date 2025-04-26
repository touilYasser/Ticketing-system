<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Titre -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $ticket->title) }}" class="form-input mt-1 block w-full" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" class="form-textarea mt-1 block w-full" rows="4" required>{{ old('description', $ticket->description) }}</textarea>
                    </div>

                    <!-- Statut -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="status" id="status" class="form-select mt-1 block w-full" required>
                            <option value="ouvert" {{ $ticket->status == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                            <option value="en_cours" {{ $ticket->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="resolu" {{ $ticket->status == 'resolu' ? 'selected' : '' }}>Résolu</option>
                            <option value="ferme" {{ $ticket->status == 'ferme' ? 'selected' : '' }}>Fermé</option>
                        </select>
                    </div>

                    <!-- Priorité -->
                    <div class="mb-4">
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priorité</label>
                        <select name="priority" id="priority" class="form-select mt-1 block w-full" required>
                            <option value="basse" {{ $ticket->priority == 'basse' ? 'selected' : '' }}>Basse</option>
                            <option value="moyenne" {{ $ticket->priority == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="haute" {{ $ticket->priority == 'haute' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>

                    <!-- Catégorie -->
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <input type="text" id="category" name="category" value="{{ old('category', $ticket->category) }}" class="form-input mt-1 block w-full" required>
                    </div>

                    <!-- Soumettre le formulaire -->
                    <div class="mb-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Mettre à jour le ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
