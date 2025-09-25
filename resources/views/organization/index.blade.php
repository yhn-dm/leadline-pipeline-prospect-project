@extends('layouts.app')

@section('content')
<!-- Topbar sticky -->
<div class="sticky top-0 bg-gray-50 border-b border-gray-200 shadow-sm z-10 px-4 md:px-8 py-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Infos organisation -->
        <div>
            <h1 class="text-xl font-semibold text-gray-700">Organisation</h1>
            <p class="text-sm text-gray-500">Bienvenue dans votre organisation.</p>
        </div>

        <!-- Bouton d'invitation -->
        @if ($organization)
            <form method="POST" action="{{ route('organizations.invite') }}" class="w-full md:w-auto">
                @csrf
                <button type="submit"
                    class="w-full md:w-auto flex items-center justify-center px-4 py-2 text-sm text-white bg-green-500 hover:bg-green-600 font-medium rounded-md shadow transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1
                               M9 20H4v-2a4 4 0 014-4h1
                               m9-4a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Inviter un Collaborateur
                </button>
            </form>
        @else
            <p class="text-red-500 text-sm">Aucune organisation disponible.</p>
        @endif
    </div>
</div>



    <!-- Contenu principal -->
    <div class="mt-4">
        <!-- Notifications -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {!! session('success') !!}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-8">
            @if ($collaborators->count() > 0)
                <!-- Wrapper avec arrondis, ombre, scroll et bordure -->
                <div class="overflow-x-auto border border-gray-200 rounded-lg shadow">
                    <div class="min-w-max w-full overflow-hidden rounded-lg">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 hidden md:table-header-group">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Nom</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Email</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Téléphone</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Rôle</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Espaces</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Listes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($collaborators as $collaborator)
                                    <tr class="md:table-row block md:border-0 border-b mb-4 md:mb-0">
                                        <td class="px-6 py-4 font-medium text-gray-900 md:table-cell block">
                                            <span class="md:hidden font-semibold text-gray-600">Nom :</span>
                                            {{ $collaborator->name }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 md:table-cell block">
                                            <span class="md:hidden font-semibold text-gray-600">Email :</span>
                                            {{ $collaborator->email }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 md:table-cell block">
                                            <span class="md:hidden font-semibold text-gray-600">Téléphone :</span>
                                            {{ $collaborator->phone ?? 'Non renseigné' }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 md:table-cell block">
                                            <span class="md:hidden font-semibold text-gray-600">Rôle :</span>
                                            @php $currentRole = $collaborator->roles->first(); @endphp
                                            @if (auth()->user()->hasRole('Admin'))
                                                <form
                                                    action="{{ route('organization.users.assign-role', $collaborator->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <select name="role_id" onchange="this.form.submit()"
                                                        class="rounded border-gray-300 text-sm shadow-sm">
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}"
                                                                @selected($currentRole && $currentRole->id === $role->id)>
                                                                {{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            @else
                                                <span class="text-sm text-gray-800 font-medium">
                                                    {{ $currentRole->name ?? 'Aucun rôle' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 md:table-cell block">
                                            <span class="md:hidden font-semibold text-gray-600">Espaces :</span>
                                            @if ($collaborator->spaces->isNotEmpty())
                                                <ul class="list-disc list-inside mt-1 space-y-1 text-sm text-gray-700">
                                                    @foreach ($collaborator->spaces as $space)
                                                        <li>
                                                            <a href="{{ route('lists.index', $space->id) }}"
                                                                class="text-blue-600 hover:underline">
                                                                {{ $space->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-gray-500 text-sm">Aucun espace</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 md:table-cell block">
                                            <span class="md:hidden font-semibold text-gray-600">Listes :</span>
                                            @if ($collaborator->lists->isNotEmpty())
                                                <ul class="list-disc list-inside mt-1 space-y-1 text-sm text-gray-700">
                                                    @foreach ($collaborator->lists as $list)
                                                        <li>
                                                            <a href="{{ route('lists.prospects.index', $list->id) }}"
                                                                class="text-blue-600 hover:underline">
                                                                {{ $list->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-gray-500 text-sm">Aucune liste</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">Aucun collaborateur trouvé.</div>
            @endif
        </div>



    @endsection
