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
            'email' => 'required|string|email|unique:medecins',
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
        $medecin->update($request->all());
        return response()->json($medecin, 200);
    }

    public function destroy($id)
    {
        Medecin::destroy($id);
        return response()->json(['message' => 'Médecin supprimé'], 200);
    }
}
