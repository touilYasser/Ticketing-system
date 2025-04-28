<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Créer un compte Helpdesk</h1>
        <p class="text-gray-600 text-sm">Inscrivez-vous pour accéder à votre espace personnel et gérer vos demandes de support.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="bg-white p-8 shadow-md rounded-lg">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Votre nom complet" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Adresse e-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Votre adresse e-mail" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"
                          placeholder="********" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"
                          placeholder="********" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Créer un compte') }}
            </x-primary-button>

            <p class="mt-4 text-center text-sm text-gray-600">
                {{ __("Déjà inscrit ?") }}
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">{{ __('Se connecter') }}</a>
            </p>
        </div>
    </form>

    <!-- Bonus: Message d'encouragement -->
    <div class="mt-8 text-center">
        <p class="text-gray-500 text-sm">Rejoignez notre communauté et bénéficiez d'un support rapide et efficace.</p>
    </div>
</x-guest-layout>
