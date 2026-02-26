@extends('layouts.guest')

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-gray-100 px-4 py-8">
        <div class="bg-white shadow-card rounded-card-lg p-6 sm:p-8 max-w-md w-full border border-gray-200/80">
            <!-- Titre -->
            <h2 class="text-2xl font-semibold text-gray-800 text-center">Connexion</h2>
            <p class="text-sm text-gray-500 text-center mt-1">Connectez-vous pour accéder à votre espace</p>

            <!-- Session Status -->
            <x-auth-session-status class="mt-4" :status="session('status')" />

            <!-- Formulaire de connexion -->
            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="text-gray-700 font-medium">Adresse email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" />
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mt-4">
                    <label for="password" class="text-gray-700 font-medium">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" />
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Se souvenir de moi -->
                <div class="flex items-center mt-4">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="remember">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <!-- Boutons -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        Connexion
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
