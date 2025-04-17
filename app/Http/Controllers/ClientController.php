<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Prospect;

class ClientController extends Controller
{
    public function index()
    {
        // Récupère tous les clients
        $clients = Client::paginate(50);

        // Renvoie la vue avec les données
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        // Retourne la vue pour créer un nouveau client
        return view('clients.create');
    }

    public function store(Request $request)
    {
        // Valide les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        // Crée le client
        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }

    public function show($id)
    {
        // Récupère un client spécifique
        $client = Client::findOrFail($id);

        return view('clients.show', compact('client'));
    }

    public function edit($id)
{
    $client = Client::findOrFail($id);
    return view('clients.edit', compact('client'));
}

    public function update(Request $request, $id)
    {
        // Valide les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        // Met à jour le client
        $client = Client::findOrFail($id);
        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy($id)
{
    $client = Client::findOrFail($id);
    $client->delete();

    // Pour une requête AJAX (fetch), retourne JSON
    if (request()->expectsJson()) {
        return response()->json(['message' => 'Client supprimé']);
    }

    // Sinon redirection normale
    return redirect()->back()->with('success', 'Client supprimé avec succès');
}


    public function convertToClient(Request $request, $listId, $prospectId)
    {
        $prospect = Prospect::findOrFail($prospectId);

        // Créer un nouveau client basé sur le prospect
        $client = new Client();
        $client->name = $prospect->name;
        $client->email = $prospect->email;
        $client->phone = $prospect->phone;
        $client->source_acquisition = $prospect->source_acquisition;
        $client->priority = $prospect->priority;
        $client->collaborator_id = $prospect->collaborator_id;
        $client->comment = $prospect->comment;
        $client->save();

        // Supprimer le prospect après transfert
        $prospect->delete();

        return response()->json(['success' => true, 'message' => 'Le prospect a été converti en client avec succès']);
    }

}
