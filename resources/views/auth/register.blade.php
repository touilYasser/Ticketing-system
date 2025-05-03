<x-guest-layout>
    <div class="mb-8 text-center animate__animated animate__fadeInDown">
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-2">Créer un compte Helpdesk</h1>
        <p class="text-gray-600 text-base">Inscrivez-vous pour accéder à votre espace personnel et gérer vos demandes de support.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="bg-white p-8 shadow-xl rounded-2xl border border-gray-100 animate__animated animate__fadeInUp animate__delay-1s transition duration-500 hover:shadow-2xl">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" class="text-indigo-600 font-medium" />
            <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Votre nom complet" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Adresse e-mail')" class="text-indigo-600 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Votre adresse e-mail" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-indigo-600 font-medium" />
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition"
                          type="password"
                          name="password"
                          required autocomplete="new-password"
                          placeholder="********" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-indigo-600 font-medium" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"
                          placeholder="********" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500" />
        </div>

        <div class="flex flex-col mt-6">
            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 transition duration-300 rounded-full py-3 text-lg">
                {{ __('Créer un compte') }}
            </x-primary-button>

            <p class="mt-4 text-center text-sm text-gray-600">
                {{ __("Déjà inscrit ?") }}
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 transition underline">{{ __('Se connecter') }}</a>
            </p>
        </div>
    </form>

    <!-- Bonus: Message d'encouragement -->
    <div class="mt-8 text-center animate__animated animate__fadeInUp animate__delay-2s">
        <p class="text-gray-500 text-sm">Rejoignez notre communauté et bénéficiez d'un <span class="text-indigo-600 font-medium">support rapide et efficace</span>.</p>
    </div>
</x-guest-layout>
