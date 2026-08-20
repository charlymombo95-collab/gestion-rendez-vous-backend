<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendezvous extends Model
{
    use HasFactory;

    // Nom explicite de la table MySQL (créée via la migration rendezvouses)
    protected $table = 'rendezvouses';

    protected $fillable = [
        'medecin_id',
        'patient_id',
        'date',
        'heure',
        'statut',
    ];

    /**
     * Le rendez-vous appartient à un médecin
     */
    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecin_id');
    }

    /**
     * Le rendez-vous appartient à un patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}