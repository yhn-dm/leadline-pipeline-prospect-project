@extends('layouts.guest')
@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-6">


        <!-- ✅ Titre principal -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">
            Bienvenue sur notre plateforme CRM
        </h1>
        <p class="text-gray-600 text-center mb-6 max-w-md">
            Gérez vos clients et optimisez vos interactions avec une solution simple et efficace.
        </p>

        <!-- ✅ Boutons d'action -->
        <div class="flex space-x-4">
            <a href="{{ route('login') }}" 
                class="px-6 py-3 bg-blue-500 text-white font-medium rounded-md shadow-md hover:bg-blue-600 transition">
                Connexion
            </a>
            <a href="{{ route('register') }}" 
                class="px-6 py-3 bg-gray-500 text-white font-medium rounded-md shadow-md hover:bg-gray-600 transition">
                Inscription
            </a>
        </div>
    </div>
@endsection