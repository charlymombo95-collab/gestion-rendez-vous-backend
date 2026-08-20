<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MedecinController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\RendezvousController;

Route::apiResource('medecins', MedecinController::class);
Route::apiResource('patients', PatientController::class);
Route::apiResource('rendezvous', RendezvousController::class);
