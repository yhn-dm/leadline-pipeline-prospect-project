@extends('layouts.guest')
@section('content')
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
            <!-- Titre -->
            <h2 class="text-2xl font-semibold text-gray-700 text-center">Créer un Compte</h2>
            <p class="text-sm text-gray-500 text-center mt-1">Rejoignez-nous en quelques secondes</p>

            <!-- Token d'invitation -->
            <input type="hidden" name="invitation" value="{{ $invitationToken }}">

            <!-- Alerte sur l'organisation -->
            @if ($organizationId)
                <p class="text-green-600 text-sm text-center mt-3">
                    Vous rejoindrez automatiquement l'organisation associée.
                </p>
            @else
                <p class="text-red-500 text-sm text-center mt-3">
                    Aucune organisation détectée. Vous pourrez en créer une après l'inscription.
                </p>
            @endif

            <!-- Formulaire d'inscription -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Si une invitation est présente, on la passe en POST -->
                @if (isset($invitationToken))
                    <input type="hidden" name="invitation" value="{{ $invitationToken }}">
                @endif

                <!-- Nom -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-900">Nom</label>
                    <input id="name" name="name" type="text" required autofocus
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                    <input id="email" name="email" type="email" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-900">Mot de passe</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmation -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-900">Confirmer le mot de
                        passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
                </div>

                <!-- Bouton -->
                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Créer un compte
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
