<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return response()->json(Patient::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|unique:patients,email',
            'password' => 'required|string|min:6',
            'telephone' => 'required|string|max:20',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $patient = Patient::create($validated);

        return response()->json($patient, 201);
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient, 200);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:patients,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'telephone' => 'sometimes|required|string|max:20',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $patient->update($validated);

        return response()->json($patient, 200);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json(['message' => 'Patient supprimé avec succès.'], 200);
    }
}