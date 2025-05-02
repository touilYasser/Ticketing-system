<x-app-layout>
    <div class="container mx-auto py-10">
        <!-- Titre principal -->
        <h2 class="text-center text-4xl font-extrabold mb-6 text-gray-800 animate-fadeInUp">Bienvenue sur Helpdesk Support</h2>
        <p class="text-center text-lg text-gray-600 mb-10 animate-fadeInUp delay-200">
            Déclarez, suivez et résolvez vos incidents rapidement et efficacement grâce à notre plateforme intuitive.
        </p>

        <!-- Espaces rôles -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Espace Clients -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-white/30 p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-2xl animate-fadeInUp">
                <h3 class="text-2xl font-semibold text-blue-700 mb-4">Espace Clients</h3>
                <p class="text-gray-700 mb-6">
                    Vous êtes un client ? Créez facilement vos tickets d'incident, suivez leur avancement en temps réel et recevez des notifications automatiques à chaque mise à jour.
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-full shadow hover:shadow-lg transform hover:scale-105 transition duration-300">
                    Se connecter
                </a>
            </div>

            <!-- Espace Agents -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-white/30 p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-2xl animate-fadeInUp delay-200">
                <h3 class="text-2xl font-semibold text-green-700 mb-4">Espace Agents</h3>
                <p class="text-gray-700 mb-6">
                    En tant qu'agent, accédez facilement aux tickets qui vous sont assignés, échangez directement avec les clients, ajoutez des commentaires, et clôturez les incidents rapidement.
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-green-500 to-green-700 text-white px-6 py-2 rounded-full shadow hover:shadow-lg transform hover:scale-105 transition duration-300">
                    Se connecter
                </a>
            </div>

            <!-- Espace Administrateur -->
            <div class="bg-gradient-to-br from-red-50 to-red-100 border-white/30 p-8 rounded-2xl shadow-lg transform transition-transform duration-300 hover:scale-105 hover:shadow-2xl animate-fadeInUp delay-400">
                <h3 class="text-2xl font-semibold text-red-700 mb-4">Espace Administrateur</h3>
                <p class="text-gray-700 mb-6">
                    Supervisez toute l'activité de la plateforme : gérez les utilisateurs, assignez les rôles et agents aux tickets, consultez les statistiques et surveillez les délais de traitement.
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-red-500 to-red-700 text-white px-6 py-2 rounded-full shadow hover:shadow-lg transform hover:scale-105 transition duration-300">
                    Se connecter
                </a>
            </div>
        </div>

        <!-- Pourquoi choisir notre Helpdesk ? -->
        <div class="mt-16 text-center">
            <h3 class="text-3xl font-extrabold mb-4 text-gray-800 animate-fadeInUp delay-600">Pourquoi choisir notre plateforme ?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition-transform duration-300 animate-fadeInUp delay-800">
                    <h4 class="text-xl font-semibold mb-2 text-blue-600">Simplicité d'utilisation</h4>
                    <p class="text-gray-600">
                        Interface intuitive et accessible, même pour les débutants. Créer ou suivre un ticket n'a jamais été aussi simple.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition-transform duration-300 animate-fadeInUp delay-900">
                    <h4 class="text-xl font-semibold mb-2 text-green-600">Réactivité garantie</h4>
                    <p class="text-gray-600">
                        Nos agents reçoivent des notifications en temps réel pour traiter vos demandes efficacement.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition-transform duration-300 animate-fadeInUp delay-1200">
                    <h4 class="text-xl font-semibold mb-2 text-red-600">Gestion centralisée</h4>
                    <p class="text-gray-600">
                        Vue d'ensemble complète pour piloter les tickets et l'activité des équipes.
                    </p>
                </div>
            </div>
        </div>

        <!-- Petit message final motivant -->
        <div class="mt-20 text-center animate-fadeInUp delay-1400">
            <p class="text-lg text-gray-700">
                Avec Helpdesk Support, vous avez l'assurance d'une <span class="font-semibold text-blue-600">prise en charge rapide</span> et <span class="font-semibold text-green-600">d'un suivi efficace</span> de vos incidents.
            </p>
            <a href="{{ route('register') }}" class="mt-6 inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-3 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 animate-pulse">
                Rejoignez-nous maintenant
            </a>
        </div>
    </div>
</x-app-layout>
