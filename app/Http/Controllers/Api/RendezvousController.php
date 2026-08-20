<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rendezvous;
use Illuminate\Http\Request;

class RendezvousController extends Controller
{

    public function index()
    {
        return response()->json(Rendezvous::with(['medecin', 'patient'])->get(), 200);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'heure' => 'required',
            'statut' => 'in:en_attente,confirmé,annulé'
        ]);

        // Vérification de la disponibilité du médecin
        $existant = Rendezvous::where('medecin_id', $request->medecin_id)
            ->where('date', $request->date)
            ->where('heure', $request->heure)
            ->first();

        if ($existant) {
            return response()->json(['error' => 'Ce créneau est déjà pris pour ce médecin.'], 422);
        }

        $rendezvous = Rendezvous::create($validated);
        return response()->json($rendezvous->load(['medecin', 'patient']), 201);
    }

    public function show($id)
    {
        $rendezvous = Rendezvous::with(['medecin', 'patient'])->findOrFail($id);
        return response()->json($rendezvous, 200);
    }

    public function update(Request $request, $id)
    {
        $rendezvous = Rendezvous::findOrFail($id);
        $rendezvous->update($request->all());
        return response()->json($rendezvous, 200);
    }

    public function destroy($id)
    {
        Rendezvous::destroy($id);
        return response()->json(['message' => 'Rendez-vous annulé/supprimé'], 200);
    }
}
