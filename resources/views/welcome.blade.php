<x-app-layout>
    <div class="container mx-auto py-10">
        <h2 class="text-center text-4xl font-bold mb-6 text-gray-800">Bienvenue sur Helpdesk Support</h2>
        <p class="text-center text-lg text-gray-600 mb-10">Déclarez, suivez et résolvez vos incidents rapidement et efficacement grâce à notre plateforme intuitive.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Espace Clients -->
            <div class="bg-white p-8 shadow-lg rounded-lg hover:shadow-xl transition">
                <h3 class="text-2xl font-semibold text-blue-700 mb-4">Espace Clients</h3>
                <p class="text-gray-600 mb-6">
                    Vous êtes un client ? Créez facilement vos tickets d'incident, suivez leur avancement en temps réel et recevez des notifications automatiques à chaque mise à jour.
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Se connecter
                </a>
            </div>

            <!-- Espace Agents -->
            <div class="bg-white p-8 shadow-lg rounded-lg hover:shadow-xl transition">
                <h3 class="text-2xl font-semibold text-green-700 mb-4">Espace Agents</h3>
                <p class="text-gray-600 mb-6">
                    En tant qu'agent, accédez aux tickets qui vous sont assignés, échangez directement avec les clients, ajoutez des commentaires, et clôturez les incidents rapidement.
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    Se connecter
                </a>
            </div>

            <!-- Espace Administrateur -->
            <div class="bg-white p-8 shadow-lg rounded-lg hover:shadow-xl transition">
                <h3 class="text-2xl font-semibold text-red-700 mb-4">Espace Administrateur</h3>
                <p class="text-gray-600 mb-6">
                    Supervisez toute l'activité de la plateforme : gérez les utilisateurs, assignez les rôles et agents aux tickets, consultez les statistiques et surveillez les délais de traitement.
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                    Se connecter
                </a>
            </div>
        </div>

        <!-- Pourquoi choisir notre Helpdesk ? -->
        <div class="mt-16 text-center">
            <h3 class="text-3xl font-bold mb-4 text-gray-800">Pourquoi choisir notre plateforme ?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                <div class="bg-gray-100 p-6 rounded-lg hover:shadow-md transition">
                    <h4 class="text-xl font-semibold mb-2 text-blue-600">Simplicité d'utilisation</h4>
                    <p class="text-gray-600">
                        Notre interface a été conçue pour être intuitive et accessible, même pour les utilisateurs débutants. Créer ou suivre un ticket n'a jamais été aussi simple.
                    </p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg hover:shadow-md transition">
                    <h4 class="text-xl font-semibold mb-2 text-green-600">Réactivité garantie</h4>
                    <p class="text-gray-600">
                        Nos agents reçoivent des notifications en temps réel et traitent vos demandes avec efficacité pour vous garantir un service rapide et de qualité.
                    </p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg hover:shadow-md transition">
                    <h4 class="text-xl font-semibold mb-2 text-red-600">Gestion centralisée</h4>
                    <p class="text-gray-600">
                        Grâce à notre tableau de bord administrateur, vous bénéficiez d'une vue d'ensemble complète pour un pilotage optimal des tickets et de l'activité de vos équipes.
                    </p>
                </div>
            </div>
        </div>

        <!-- Petit message final motivant -->
        <div class="mt-20 text-center">
            <p class="text-lg text-gray-700">Avec Helpdesk Support, vous avez l'assurance d'une <span class="font-semibold text-blue-600">prise en charge rapide</span> et <span class="font-semibold text-green-600">d'un suivi efficace</span> de vos incidents.</p>
            <a href="{{ route('register') }}" class="mt-6 inline-block bg-indigo-600 text-white px-8 py-3 rounded-full hover:bg-indigo-700 transition">
                Rejoignez-nous maintenant
            </a>
        </div>
    </div>
</x-app-layout>
