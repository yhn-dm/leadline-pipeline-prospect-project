<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prospect;
use App\Models\Lists;
use App\Models\User;
use App\Models\Client;
use App\Models\Status;
use App\Models\Activity;

class ProspectController extends Controller
{
    public function index($listId)
    {
        $list = Lists::findOrFail($listId);
        $prospects = $list->prospects()->paginate(50);
        $users = User::all();
        $statuses = Status::all();
        $lists = Lists::where('space_id', $list->space_id)->where('id', '!=', $listId)->get();
        $space = $list->space;

        return view('prospects.index', compact('list', 'listId', 'prospects', 'users', 'statuses', 'lists', 'space'));
    }

    public function create($listId)
    {
        return view('prospects.create', compact('listId'));
    }


    public function show($listId, $prospectId)
    {
        $prospect = Prospect::where('list_id', $listId)
            ->with(['list.space', 'status', 'collaborator'])
            ->findOrFail($prospectId);

        $lists = Lists::where('space_id', $prospect->list->space_id)->where('id', '!=', $listId)->get();
        $users = User::all();
        $statuses = Status::all();

        return view('prospects.show', compact('prospect', 'lists', 'users', 'statuses'));
    }



    public function edit($listId, $prospectId)
    {
        $prospect = Prospect::where('list_id', $listId)->findOrFail($prospectId);
        return view('prospects.edit', compact('prospect', 'listId'));
    }



    public function store(Request $request, $listId)
    {
        // Log des données pour vérifier ce qui est reçu
        \Log::info('Données reçues pour création de prospect :', $request->all());

        // Validation des champs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'status' => 'required|string|in:new,contacted,interested,converted,lost',
            'source_acquisition' => 'nullable|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'collaborator_id' => 'nullable|exists:users,id',
        ]);

        // Vérifier que la liste existe
        $list = Lists::findOrFail($listId);

        // Création du prospect
        $prospect = new Prospect();
        $prospect->name = $validated['name'];
        $prospect->email = $validated['email'];
        $prospect->phone = $validated['phone'];
        $prospect->comment = $validated['comment'];
        $prospect->list_id = $list->id;
        $prospect->status = $validated['status'];
        $prospect->source_acquisition = $validated['source_acquisition'] ?? null;
        $prospect->priority = $validated['priority'] ?? null;
        $prospect->collaborator_id = $validated['collaborator_id'] ?? null;
        $prospect->save();

        return redirect()->route('lists.prospects.index', $list->id)->with('success', 'Prospect ajouté avec succès.');
    }



    public function update(Request $request, $listId, $prospectId)
    {
        // Log des données reçues pour vérifier
        \Log::info('Données reçues pour update :', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'status' => 'required|string|in:new,contacted,interested,converted,lost',
            'source_acquisition' => 'nullable|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'collaborator_id' => 'nullable|exists:users,id',
            'transfer_list' => 'nullable|exists:lists,id'
        ]);

        $prospect = Prospect::where('list_id', $listId)->findOrFail($prospectId);

        if (!empty($validated['transfer_list']) && $validated['transfer_list'] != $listId) {
            $newList = Lists::findOrFail($validated['transfer_list']);
            $prospect->list_id = $newList->id;
        }

        if ($validated['status'] === 'converted') {
            $client = Client::create([
                'name' => $prospect->name,
                'email' => $prospect->email,
                'phone' => $prospect->phone,
                'description' => $prospect->comment,
                'converted_by_user_id' => auth()->id(),   // 👈
                'converted_at' => now(),          // 👈
            ]);

            $prospect->delete();
            return redirect()->route('clients.index')
                ->with('success', 'Prospect converti en client avec succès.');
        }


        $prospect->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'comment' => $validated['comment'],
            'status' => $validated['status'],
            'source_acquisition' => $validated['source_acquisition'] ?? null,
            'priority' => $validated['priority'] ?? null,
            'collaborator_id' => $validated['collaborator_id'] ?? null
        ]);

        return redirect()->route('lists.prospects.index', $prospect->list_id)->with('success', 'Prospect mis à jour avec succès.');
    }

    public function destroy($listId, $prospectId)
    {
        $prospect = Prospect::where('list_id', $listId)->findOrFail($prospectId);

        $prospect->delete();

        return redirect()->route('lists.prospects.index', $listId)->with('success', 'Prospect supprimé avec succès.');
    }

    public function convertToClient($listId, $prospectId)
    {
        $prospect = Prospect::where('list_id', $listId)->findOrFail($prospectId);

        // Logique de conversion en client

        return redirect()->route('lists.prospects.index', $listId)->with('success', 'Prospect converti en client.');
    }
}
