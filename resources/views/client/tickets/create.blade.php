<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un nouveau ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong class="font-bold">Oups !</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('client.tickets.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priorité</label>
                        <select name="priority" id="priority" class="mt-1 block w-full" required>
                            <option value="basse">Basse</option>
                            <option value="moyenne">Moyenne</option>
                            <option value="haute">Haute</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <input type="text" name="category" id="category" class="mt-1 block w-full" required>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Créer le ticket</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
