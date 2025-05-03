<x-guest-layout>
    <div class="mb-8 text-center animate__animated animate__fadeInDown">
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-2">Bienvenue sur Cipher Pol Support</h1>
        <p class="text-gray-600 text-base">Connectez-vous pour accéder à votre espace personnel et gérer vos tickets d'incidents.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 animate__animated animate__fadeIn" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white p-8 shadow-xl rounded-2xl border border-gray-100 animate__animated animate__fadeInUp animate__delay-1s transition duration-500 hover:shadow-2xl">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" class="text-indigo-600 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Entrez votre adresse e-mail" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-indigo-600 font-medium" />
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition"
                          type="password"
                          name="password"
                          required autocomplete="current-password"
                          placeholder="********" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-800 transition" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col mt-6">
            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 transition duration-300 rounded-full py-3 text-lg">
                {{ __('Se connecter') }}
            </x-primary-button>

            @if (Route::has('register'))
                <p class="mt-4 text-center text-sm text-gray-600">
                    {{ __("Pas encore inscrit ?") }}
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 transition underline">{{ __('Créer un compte') }}</a>
                </p>
            @endif
        </div>
    </form>

    <!-- Petit texte motivant -->
    <div class="mt-8 text-center animate__animated animate__fadeInUp animate__delay-2s">
        <p class="text-gray-500 text-sm">Besoin d'aide ? <span class="text-indigo-600 font-medium">Contactez notre support technique à tout moment.</span></p>
    </div>
</x-guest-layout>
