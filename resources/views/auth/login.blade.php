<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenue sur Helpdesk Support</h1>
        <p class="text-gray-600 text-sm">Connectez-vous pour accéder à votre espace personnel et gérer vos tickets d'incidents.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white p-8 shadow-md rounded-lg">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Entrez votre adresse e-mail" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password"
                          placeholder="********" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Se connecter') }}
            </x-primary-button>

            @if (Route::has('register'))
                <p class="mt-4 text-center text-sm text-gray-600">
                    {{ __("Pas encore inscrit ?") }}
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">{{ __('Créer un compte') }}</a>
                </p>
            @endif
        </div>
    </form>

    <!-- Bonus: Ajout d'un petit texte motivant -->
    <div class="mt-8 text-center">
        <p class="text-gray-500 text-sm">Besoin d'aide ? Contactez notre support technique à tout moment.</p>
    </div>
</x-guest-layout>
