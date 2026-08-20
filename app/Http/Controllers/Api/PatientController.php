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
            'email' => 'required|string|email|unique:patients',
            'password' => 'required|string|min:6',
            'telephone' => 'required|string',
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
        $patient->update($request->all());
        return response()->json($patient, 200);
    }

    public function destroy($id)
    {
        Patient::destroy($id);
        return response()->json(['message' => 'Patient supprimé'], 200);
    }
}
