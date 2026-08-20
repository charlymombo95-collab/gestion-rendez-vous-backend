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

        $occupe = Rendezvous::where('medecin_id', $request->medecin_id)
            ->where('date', $request->date)
            ->where('heure', $request->heure)
            ->exists();

        if ($occupe) {
            return response()->json([
                'message' => 'Ce médecin a déjà un rendez-vous prévu à cette date et cette heure.'
            ], 422);
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

        $validated = $request->validate([
            'medecin_id' => 'sometimes|required|exists:medecins,id',
            'patient_id' => 'sometimes|required|exists:patients,id',
            'date' => 'sometimes|required|date',
            'heure' => 'sometimes|required',
            'statut' => 'sometimes|in:en_attente,confirmé,annulé',
        ]);

        $medecinId = $request->input('medecin_id', $rendezvous->medecin_id);
        $date = $request->input('date', $rendezvous->date);
        $heure = $request->input('heure', $rendezvous->heure);

        $occupe = Rendezvous::where('medecin_id', $medecinId)
            ->where('date', $date)
            ->where('heure', $heure)
            ->where('id', '!=', $id)
            ->exists();

        if ($occupe) {
            return response()->json([
                'message' => 'Ce créneau est déjà réservé pour ce médecin.'
            ], 422);
        }

        $rendezvous->update($validated);

        return response()->json($rendezvous->load(['medecin', 'patient']), 200);
    }

    public function destroy($id)
    {
        $rendezvous = Rendezvous::findOrFail($id);
        $rendezvous->delete();

        return response()->json(['message' => 'Rendez-vous annulé et supprimé avec succès.'], 200);
    }
}

