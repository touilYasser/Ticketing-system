<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Helpdesk - Gestion des tickets</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">

    <header class="bg-blue-600 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Helpdesk - Support Technique</h1>
            <nav>
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-white px-4 py-2 bg-blue-700 rounded hover:bg-blue-800">Dashboard</a>
                    @elseif(Auth::user()->role == 'agent')
                        <a href="{{ route('agent.dashboard') }}" class="text-white px-4 py-2 bg-blue-700 rounded hover:bg-blue-800">Dashboard</a>
                    @else
                        <a href="{{ route('client.dashboard') }}" class="text-white px-4 py-2 bg-blue-700 rounded hover:bg-blue-800">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-white px-4 py-2 bg-blue-700 rounded hover:bg-blue-800">Connexion</a>
                    <a href="{{ route('register') }}" class="ml-2 text-white px-4 py-2 bg-green-600 rounded hover:bg-green-700">Inscription</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-10">
        <h2 class="text-center text-3xl font-bold mb-4">Bienvenue sur notre plateforme Helpdesk</h2>
        <p class="text-center text-gray-700 mb-6">Déclarez, suivez et gérez les incidents en toute simplicité.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-5">
            <div class="bg-white p-6 shadow-md rounded">
                <h3 class="text-lg font-semibold mb-2">Espace Clients</h3>
                <p class="text-gray-600 mb-4">Créez des tickets pour signaler un incident et suivez l'évolution de vos demandes.</p>
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Se connecter</a>
            </div>

            {{-- Agent --}}
            <div class="bg-white p-6 shadow-md rounded">
                <h3 class="text-lg font-semibold mb-2">Espace Agents</h3>
                <p class="text-gray-600 mb-4">Accédez aux tickets assignés, ajoutez des commentaires et résolvez les incidents efficacement.</p>
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Se connecter</a>
            </div>

            {{-- Admin --}}
            <div class="bg-white p-6 shadow-md rounded">
                <h3 class="text-lg font-semibold mb-2">Administrateur</h3>
                <p class="text-gray-600 mb-4">Gérez les utilisateurs, les rôles et la supervision générale du système de support.</p>
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Se connecter</a>
            </div>
        </div>
    </main>

    @include('components.footer')

</body>
</html>
