<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="
                        @guest
                            {{ route('welcome') }}
                        @else
                            @if (Auth::user()->role === 'admin')
                                {{ route('admin.dashboard') }}
                            @elseif (Auth::user()->role === 'agent')
                                {{ route('agent.dashboard') }}
                            @else
                                {{ route('client.dashboard') }}
                            @endif
                        @endguest
                    ">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard Admin') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                                {{ __('Utilisateurs') }}
                            </x-nav-link>
                        @elseif(auth()->user()->role === 'agent')
                            <x-nav-link :href="route('agent.dashboard')" :active="request()->routeIs('agent.dashboard')">
                                {{ __('Dashboard Agent') }}
                            </x-nav-link>
                        @elseif(auth()->user()->role === 'client')
                            <x-nav-link :href="route('client.tickets.index')" :active="request()->routeIs('client.tickets.index')">
                                {{ __('Mes Tickets') }}
                            </x-nav-link>
                            <x-nav-link :href="route('client.tickets.create')" :active="request()->routeIs('client.tickets.create')">
                                {{ __('Créer un Ticket') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Connexion</a>
                        <a href="{{ route('register') }}" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
                            Inscription
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard Admin') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                        {{ __('Utilisateurs') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->role === 'agent')
                    <x-responsive-nav-link :href="route('agent.dashboard')" :active="request()->routeIs('agent.dashboard')">
                        {{ __('Dashboard Agent') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->role === 'client')
                    <x-responsive-nav-link :href="route('client.tickets.index')" :active="request()->routeIs('client.tickets.index')">
                        {{ __('Mes Tickets') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('client.tickets.create')" :active="request()->routeIs('client.tickets.create')">
                        {{ __('Créer un Ticket') }}
                    </x-responsive-nav-link>
                @endif
            @endauth

            @guest
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Connexion') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Inscription') }}
                </x-responsive-nav-link>
            @endguest
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
