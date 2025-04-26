<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div>
                        <label for="name" class="block font-medium text-gray-700">Nom</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="mt-4">
                        <label for="email" class="block font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full" value="{{ old('email') }}" required>
                    </div>

                    <div class="mt-4">
                        <label for="password" class="block font-medium text-gray-700">Mot de passe</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full" required>
                    </div>

                    <div class="mt-4">
                        <label for="role" class="block font-medium text-gray-700">Rôle</label>
                        <select name="role" id="role" class="mt-1 block w-full" required>
                            <option value="client">Client</option>
                            <option value="agent">Agent</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer un utilisateur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
