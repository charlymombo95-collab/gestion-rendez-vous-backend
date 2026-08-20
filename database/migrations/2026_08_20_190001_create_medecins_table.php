<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    public function index()
    {
        return response()->json(Medecin::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
            'email' => 'required|string|email|unique:medecins,email',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $medecin = Medecin::create($validated);

        return response()->json($medecin, 201);
    }

    public function show($id)
    {
        $medecin = Medecin::findOrFail($id);
        return response()->json($medecin, 200);
    }

    public function update(Request $request, $id)
    {
        $medecin = Medecin::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'specialite' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:medecins,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $medecin->update($validated);

        return response()->json($medecin, 200);
    }

    public function destroy($id)
    {
        $medecin = Medecin::findOrFail($id);
        $medecin->delete();

        return response()->json(['message' => 'Médecin supprimé avec succès.'], 200);
    }
}
